<?php

namespace App\Rules;

use App\Services\CryptoNodeService;
use Illuminate\Contracts\Validation\Rule;

class CryptoNodeRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $nodeService = new CryptoNodeService($attribute);
        return $nodeService->validateAddress($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute address must be valid.';
    }
}
