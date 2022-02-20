<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('disposable:update')->daily()->withoutOverlapping();

        $schedule->command('exchange:rates')
            ->everyMinute()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/exchange-rates/'. now()->format('d-m-Y') . '.log'));

        $schedule->command('store:statistics')
            ->hourly()
            ->withoutOverlapping();

        $schedule->command('calculate:profit')
            ->everyMinute()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/calculate/'. now()->format('d-m-Y') . '.log'));

        $schedule->command('crypto:transactions')
            ->everyMinute()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/crypto/'. now()->format('d-m-Y') . '-transactions.log'));

        $schedule->command('crypto:accept')
            ->everyMinute()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/crypto/'. now()->format('d-m-Y') . '-accept.log'));


        $schedule->command('payouts:crypto')
            ->everyMinute()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/payouts/'. now()->format('d-m-Y') . '-crypto.log'));

        $schedule->command('payouts:epaycore')
            ->everyMinute()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/payouts/'. now()->format('d-m-Y') . '-epaycore.log'));

        $schedule->command('payouts:perfectmoney')
            ->everyMinute()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/payouts/'. now()->format('d-m-Y') . '-perfectmoney.log'));

//        $schedule->command('payouts:paykassa')
//            ->everyMinute()
//            ->withoutOverlapping()
//            ->appendOutputTo(storage_path('logs/payouts/'. now()->format('d-m-Y') . '-paykassa.log'));

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
