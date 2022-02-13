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

    public static function statusColor(string $status) {
        switch ($status) {
            case 'active':
            case 'paid':
                return 'success';
            case 'pending':
                return 'warning';
            case 'cancelled':
                return 'danger';
            case 'frozen':
                return 'primary';
            case 'finished':
                return 'secondary';
        }
    }

    public static function formatDepositAddress($depositAddress, $paymentSystemValue)
    {
        $depositAddress = str_replace($paymentSystemValue . ':', '', $depositAddress);

        return $paymentSystemValue . ':' .$depositAddress;
    }

}
