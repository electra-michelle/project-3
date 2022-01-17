<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\StatisticsService;
use Illuminate\Console\Command;
use App\Models\Statistic;

class StoreStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:statistics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stores statistics';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private StatisticsService $statisticsService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = $this->statisticsService->getStatistics();
        foreach ($data['paymentSystems'] as $paymentSystem) {
            if(isset($data['walletData'][$paymentSystem->value])) {
                foreach ($data['walletData'][$paymentSystem->value] as $key => $value) {
                    Statistic::create([
                        'type' => $key,
                        'payment_system_id' => $paymentSystem->id,
                        'value' => $value,
                    ]);
                }
            }
        }

        foreach ($data['walletData']['all'] as $key => $value) {
            Statistic::create([
                'type' => $key,
                'value' => $value,
            ]);
        }

        Statistic::create([
            'type' => 'total_accounts',
            'value' => User::count() ?? 0,
        ]);

    }
}
