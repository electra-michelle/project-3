<?php

namespace App\Http\Controllers\Admin;

use App\Models\Deposit;
use App\Models\ExchangeRate;
use App\Models\Payout;
use App\Models\Statistic;
use App\Models\User;
use App\Models\Message;
use App\Http\Controllers\Controller;
use App\Services\StatisticsService;

class DashboardController extends Controller
{
    public function index(StatisticsService $statisticsService)
    {
        $data['users'] = User::count();
        $data['messages'] = Message::where('is_read', false)->count();
        $data['depositsCount'] = Deposit::where(fn($query) => (
            $query->where('status', 'active')
            ->orWhere('status', 'finished')
        ))->count();

        $statistics = Statistic::latest()
            ->with('paymentSystem')
            ->where(fn($query) => (
                $query->where('type', 'total_accounts')
                    ->orWhere('type', 'deposit_count')
            ))
            ->where('created_at', '>', now()->subHours(48))
            ->whereNull('payment_system_id')
            ->get()
            ->reverse();

        $data['charts'] = [
            'total_accounts' => [],
            'deposit_count' => [],
        ];

        foreach ($statistics as $statistic) {
            $data['charts'][$statistic->type][] = [
                'x' => $statistic->created_at,
                'y' => $statistic->value,
            ];
        }

        if(empty($data['charts']['total_accounts'])) {
            $data['charts']['total_accounts'][] = [
                'x' => now()->subHour(),
                'y' => 0,
            ];
        }

        if(empty($data['charts']['deposit_count'])) {
            $data['charts']['deposit_count'][] = [
                'x' => now()->subHour(),
                'y' => 0,
            ];
        }

        $data['charts']['deposit_count'][] = [
            'x' => now(),
            'y' => $data['depositsCount'],
        ];

        $data['charts']['total_accounts'][] = [
            'x' => now(),
            'y' => $data['users'],
        ];

        $data['depositSum'] = $statisticsService->convertedDepositSum();
        $data['payoutSum'] =  $statisticsService->convertedPayoutSum();
        $data['pendingPayouts'] =  $statisticsService->convertedPayoutSum(
            status: 'pending'
        );

        $data['inBalances'] = $statisticsService->convertedAvailableBalance();

        return view('admin.dashboard', $data);
    }
}
