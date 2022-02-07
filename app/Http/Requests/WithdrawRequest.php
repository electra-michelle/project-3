<?php

namespace App\Http\Requests;

use App\Models\PaymentSystem;
use App\Models\UserAccount;
use Illuminate\Foundation\Http\FormRequest;

class WithdrawRequest extends FormRequest
{

    private $paymentSystem = null;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $paymentSystems = PaymentSystem::active()->get();
        $paymentSystemValues = $paymentSystems->pluck('value')->toArray();

        $rules = [
            'amount' => ['required', 'numeric'],
            'payment_system' => ['required', 'in:' . implode(',', $paymentSystemValues)]
        ];

        $paymentSystemData = $paymentSystems->where('value', $this->input('payment_system'))->first();
        if($paymentSystemData) {
            $this->paymentSystem = $paymentSystemData;
            $rules['amount'][] = 'regex:/^\d*(\.\d{1,' . $paymentSystemData->decimals . '})?$/';
            $rules['amount'][] = 'min:' . number_format($paymentSystemData->withdraw_minimum,  $paymentSystemData->decimals, '.', '');
        }
        //dd($rules, $this->all());

        return $rules;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        if($validator->passes()) {
            $validator->after(function ($validator) {
                if($this->paymentSystem && $this->input('amount')) {
                    $wallet = UserAccount::where('payment_system_id', $this->paymentSystem->id)
                        ->where('user_id', auth()->user()->id)
                        ->first();
                    if(!$wallet || $wallet->balance < $this->input('amount')) {
                        $validator->errors()->add('amount', 'Insuffient funds in your account balance. Available balance: ' . ($wallet?->balance ?? 0) . ' ' . $this->paymentSystem->currency);
                    }

                    if(!$wallet || !$wallet->wallet) {
                        $validator->errors()->add('amount', 'Please, provide your ' . $this->paymentSystem->name . ' wallet in account settings.');
                    }
                }
            });
        }
    }
}
