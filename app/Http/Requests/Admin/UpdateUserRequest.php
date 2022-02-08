<?php

namespace App\Http\Requests\Admin;

use App\Models\PaymentSystem;
use App\Services\PaymentSystemService;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $paymentSystems = PaymentSystem::active()->get();
        $rules = [];
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
