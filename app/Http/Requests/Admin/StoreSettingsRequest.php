<?php

namespace App\Http\Requests\Admin;

use App\Models\PaymentSystem;
use Illuminate\Foundation\Http\FormRequest;

class StoreSettingsRequest extends FormRequest
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

        $rules = [];

        $paymentSystems = PaymentSystem::active()->get('value');
        foreach ($paymentSystems as $paymentSystem) {
            $rules[$paymentSystem->value] = ['required', 'boolean'];
        }

        return $rules;
    }
}
