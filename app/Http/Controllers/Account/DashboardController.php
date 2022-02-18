<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Services\StatisticsService;

class DashboardController extends Controller
{
    public function index(StatisticsService $statisticsService)
    {
        $user = auth()->user();
        $user->load(['deposits' => fn($query) => (
        $query->where('status', '<>', 'cancelled')
            ->latest()
        ), 'deposits.paymentSystem']);

        $referrals = $user->referrals()->count();

        $totalDeposit = $statisticsService->convertedDepositSum($user->id);
        $totalPayout = $statisticsService->convertedPayoutSum($user->id);
        $balance = $statisticsService->convertedAvailableBalance($user->id);

        return view('account.dashboard', compact('user', 'totalPayout', 'totalDeposit', 'referrals', 'balance'));
    }
}
