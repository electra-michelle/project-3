<?php

namespace App\Http\Requests;

use App\Helpers\CustomHelper;
use App\Models\PaymentSystem;
use App\Models\Plan;
use App\Models\PlanLimit;
use App\Models\User;
use App\Models\UserAccount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepositRequest extends FormRequest
{

    private ?int $paymentSystemId = null;
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
        $plans = Plan::get();
        $paymentSystemValues = $paymentSystems->pluck('value')->toArray();
        $planValues = $plans->pluck('value')->toArray();

        // Default Rules
        $rules =  [
            'amount' => ['required', 'numeric'],
            'investment_plan' => ['required', 'in:' . implode(',', $planValues)],
            'payment_system' => ['required', 'in:' . implode(',', $paymentSystemValues)],
            'payment_method' => ['required',  'in:payment_processor,account_balance']
        ];

        // Get decimals for numeric value and add rule
        $decimalsByMethod = $paymentSystems->pluck('decimals', 'value')->toArray();
        if($this->input('payment_system') && isset($decimalsByMethod[$this->input('payment_system')])) {
            $rules['amount'][] = 'regex:/^\d*(\.\d{1,' . $decimalsByMethod[$this->input('payment_system')] . '})?$/';
        }

        if(
            $this->input('investment_plan') &&
            $this->input('payment_system') &&
            in_array($this->input('investment_plan'), $planValues) &&
            in_array($this->input('payment_system'), $paymentSystemValues)
        ) {
            $paymentSystem = $paymentSystems->where('value', $this->input('payment_system'))->first();
            $planId = $plans->where('value', $this->input('investment_plan'))->first()->id;
            $planLimit = PlanLimit::where('plan_id', $planId)
                ->where('currency', $paymentSystem->currency)
                ->first();

            $this->paymentSystemId = $paymentSystem->id;

            if($planLimit->min_amount != -1) {
                $rules['amount'][] = 'min:' . CustomHelper::formatAmount($planLimit->min_amount ,$paymentSystem->decimals);
            }

            if($planLimit->max_amount != -1) {
                $rules['amount'][] = 'max:' . CustomHelper::formatAmount($planLimit->max_amount ,$paymentSystem->decimals);
            }
        }

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
                if ($this->input('payment_method') == 'account_balance' && $this->paymentSystemId) {
                    $wallet = UserAccount::where('payment_system_id', $this->paymentSystemId)
                        ->where('user_id', auth()->user()->id)
                        ->first();
                    if (!$wallet || $wallet->balance < $this->input('amount')) {
                        $validator->errors()->add('amount', 'Insuffient funds in your account balance.');
                    }
                }
            });
        }
    }
}
