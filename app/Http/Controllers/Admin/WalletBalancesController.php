<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use App\Services\StatisticsService;

class WalletBalancesController extends Controller
{

    public function __construct(private StatisticsService $statisticsService)
    {}

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data = $this->statisticsService
            ->getStatistics();

        $statistics = Statistic::latest()
            ->with('paymentSystem')
            ->where('type', 'balance')
            ->where('created_at', '>', now()->subHours(48))
            ->get()
            ->reverse();

        $data['charts'] = [];
        foreach ($statistics as $statistic) {
            $key = $statistic->payment_system_id ? $statistic->paymentSystem->value : 'all';

            $data['charts'][$key]['currency'] = $key == 'all' ?  'USD' : $statistic->paymentSystem->currency;
            $data['charts'][$key]['balance'][] = [
                'x' => $statistic->created_at,
                'y' => $statistic->value,
            ];
        }


        return view('admin.balances.balances', $data);
    }

}
