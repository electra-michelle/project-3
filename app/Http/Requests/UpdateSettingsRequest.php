<?php

namespace App\Http\Requests;

use App\Models\PaymentSystem;
use App\Rules\CryptoNodeRule;
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

        return $rules;
    }
}
