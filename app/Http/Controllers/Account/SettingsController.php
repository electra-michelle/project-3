<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingsRequest;
use App\Models\PaymentSystem;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = auth()->user();

        $wallets = $user->wallets->pluck('wallet', 'payment_system_id')->toArray();
        $paymentSystems = PaymentSystem::active()->get();

        return view('account.settings', compact('user', 'paymentSystems', 'wallets'));
    }

    /**
     * @param UpdateSettingsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettings(UpdateSettingsRequest $request)
    {

        $user = auth()->user();
        $user->name = $request->input('name');
        $user->country = $request->input('country');
        if($request->input('new_password')) {
            $user->password = Hash::make($request->input('new_password'));
        }
        $user->save();

        $paymentSystems = PaymentSystem::active()->get();
        foreach ($paymentSystems as $paymentSystem){
            if($request->input($paymentSystem->value)) {
                $user->wallets()->updateOrCreate([
                    'payment_system_id' => $paymentSystem->id
                ], [
                    'wallet' => $request->input($paymentSystem->value)
                ]);
            }
        }

        return redirect()->back()
            ->with(['settings_updated' => 'Your account settings has been successfully updated.']);
    }
}
