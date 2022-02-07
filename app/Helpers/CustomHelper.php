<?php

namespace App\Helpers;

class CustomHelper
{
    public static function isEmailNotificationEnabled(string $name): bool
    {
        return config('notifications.email.enabled') && config('notifications.email.categories.' . $name);
    }

    public static function formatAmount(float|int $amount, int $decimals)
    {
        return number_format($amount, $decimals, '.', '');
    }

}
