<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        return view('admin.balances.balances', $data);
    }

}
