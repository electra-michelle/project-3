<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PaymentSystem;
use App\Notifications\RegistrationNotification;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Rules\CryptoNodeRule;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $paymentSystems;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');

        $this->paymentSystems = PaymentSystem::active()->get();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'country' => ['nullable', 'string', 'max:255']
        ];

        foreach ($this->paymentSystems as $paymentSystem) {
            $rules[$paymentSystem->value] = ['nullable', 'string', 'max:255'];
            switch($paymentSystem->value) {
                case 'bitcoin':
                case 'bitcoincash':
                case 'litecoin':
                case 'dash':
                    $rules[$paymentSystem->value][] = new CryptoNodeRule();
                    break;
                case 'epaycore':
                    $rules[$paymentSystem->value][] = 'regex:/^[Ee][\d]{6,9}$/';
                    break;

            }
        }

        return Validator::make($data, $rules);
    }

    /**
     * @return null
     */
    protected function findUpline()
    {
        $upline = null;
        if(session()->has('ref')) {
            $upline = User::where('ref_url', '=', session('ref'))->first()?->id;

            session()->forget('ref');
        }

        return $upline;
    }

    /**
     *
     */
    protected function generateReferralUrl()
    {
        $ref_url = Str::random(12);
        $count = User::where('ref_url', '=', $ref_url)->count();
        if($count > 0) {
            $ref_url = $this->generateReferralUrl();
        }

       return $ref_url;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'country' => $data['country'] ?? '',
            'upline' => $this->findUpline(),
            'ref_url' => $this->generateReferralUrl()
        ]);

        foreach ($this->paymentSystems as $paymentSystem) {
            if(isset($data[$paymentSystem->value])) {
                $user->wallets()->create([
                    'wallet' => $data[$paymentSystem->value],
                    'payment_system_id' => $paymentSystem->id
                ]);
            }
        }

        return $user;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $paymentSystems = $this->paymentSystems;

        return view('auth.register', compact('paymentSystems'));
    }


    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        if(config('hyip.notifications.email_notifications_enabled') && config('hyip.notifications.categories')) {
            $user->notify(new RegistrationNotification());
        }
    }

}