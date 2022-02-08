<?php

namespace App\Http\Controllers\Admin;

use App\Models\Deposit;
use App\Services\StatisticsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepositsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(StatisticsService $statisticsService, $status = null)
    {
        $deposits = Deposit::with(['paymentSystem', 'plan', 'user'])
        ->withMax('planPeriod', 'period_end')
        ->when($status, fn($query) => (
            $query->where('status', $status)
        ))
        ->latest()
        ->paginate(15);

        $depositsCount = Deposit::where(fn($query) => (
        $query->where('status', 'active')
            ->orWhere('status', 'finished')
        ))->count();

        $depositSum = $statisticsService->convertedDepositSum();
        $activeDeposits = $statisticsService->convertedDepositSum(
            status: 'active'
        );
        $finishedDeposits = $statisticsService->convertedDepositSum(
            status: 'finished'
        );

        return view('admin.deposits.list', compact('deposits', 'depositsCount', 'depositSum', 'activeDeposits', 'finishedDeposits'));
    }

}
