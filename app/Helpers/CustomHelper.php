<?php

namespace App\Helpers;

class CustomHelper
{
    public static function isEmailNotificationEnabled(string $name): bool
    {
        return config('notifications.email.enabled') && config('notifications.email.categories.' . $name);
    }

}
