<?php

namespace App\Http\Requests;

use App\Models\PaymentSystem;
use App\Rules\CryptoNodeRule;
use App\Services\PaymentSystemService;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{

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
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'old_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'required_with:old_password', 'string', 'min:8', 'confirmed']
        ];

        $paymentSystems = PaymentSystem::active()->get();

        foreach ($paymentSystems as $paymentSystem) {
            $rules[$paymentSystem->value] = ['nullable', 'string', 'max:255'];

            $rule = PaymentSystemService::getValidationRule($paymentSystem->value);
            if($rule) {
                $rules[$paymentSystem->value][] = $rule;
            }
        }

        return $rules;
    }
}
