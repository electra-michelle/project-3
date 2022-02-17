<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;

class CustomHelper
{
    public static function isEmailNotificationEnabled(string $name): bool
    {
        return config('notifications.email.enabled') && config('notifications.email.categories.' . $name);
    }

    public static function isBroadcastNotificationEnabled(string $name): bool
    {
        return config('notifications.broadcast.enabled') && config('notifications.broadcast.categories.' . $name);
    }

    public static function formatAmount(float|int $amount, int $decimals): string
    {
        return number_format($amount, $decimals, '.', '');
    }

    public static function statusColor(string $status)
    {
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

    public static function formatDepositAddress($depositAddress, $paymentSystemValue): string
    {
        $depositAddress = str_replace($paymentSystemValue . ':', '', $depositAddress);

        return $paymentSystemValue . ':' . $depositAddress;
    }

    public static function formatCalculatorJson(Collection $plans): string
    {
        $calculatorData = [];
        foreach ($plans as $plan) {
            $calculatorData[$plan->value] = [
                'period' => round($plan->periods_max_period_end),
                'interest' => round($plan->periods_avg_interest, 8),
                'principal_return' => $plan->principal_return
            ];

            foreach ($plan->limits as $limit) {
                $roundNumber = 1;
                for ($x = 0; $x < $limit->decimals; $x++) {
                    $roundNumber *= 10;
                }

                $calculatorData[$plan->value]['limits'][$limit->currency] = [
                    'min' => $limit->min_amount,
                    'max' => $limit->max_amount,
                    'decimals' => $limit->decimals,
                    'rounder' => $roundNumber
                ];
            }
        }

        return json_encode($calculatorData);
    }

}
