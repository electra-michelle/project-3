<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Helpers\TronHelper;

class TronNetworkRule implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($attribute == 'tron_trc20_usdt') {
            if (substr($value, 0, 1) != "T" || strlen($value) != 34) {
                return false;
            }
        }

        $tronHelper = new TronHelper($attribute);
        return $tronHelper->validateAddress($value);
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
