<?php

namespace App\Http\Controllers\Admin;

use App\Models\Deposit;
use App\Models\ExchangeRate;
use App\Models\Payout;
use App\Models\Statistic;
use App\Models\User;
use App\Models\Message;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
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

        $data['charts'] = [];
        foreach ($statistics as $statistic) {
            $data['charts'][$statistic->type][] = [
                'x' => $statistic->created_at,
                'y' => $statistic->value,
            ];
        }

        $data['depositSum'] = 0;
        $totalDeposits = Deposit::join('payment_systems', 'payment_systems.id', '=', 'deposits.payment_system_id')
            ->where(function($subQuery) {
                return $subQuery->where('status', 'active')->orWhere('status', 'finished');
            })
            ->selectRaw('user_id, payment_systems.currency as currency, payment_systems.decimals as decimals, payment_system_id, sum(`amount`) as total_deposit')
            ->groupBy('payment_systems.currency')
            ->get();

        foreach ($totalDeposits as $totalDeposit) {
            if($totalDeposit->currency != 'USD') {
                $exchangeRate = ExchangeRate::where('from', $totalDeposit->currency)->first();
                $data['depositSum'] += $totalDeposit->total_deposit * (json_decode($exchangeRate?->rate)?->USD ?? 1);
            } else {
                $data['depositSum'] += $totalDeposit->total_deposit;
            }
            $data['depositSum'] = round($data['depositSum'], 2);
        }

        $data['payoutSum'] = 0;
        $totalPayouts = Payout::join('payment_systems', 'payment_systems.id', '=', 'payouts.payment_system_id')
            ->where('status', 'paid')
            ->selectRaw('user_id, payment_systems.currency as currency, payment_systems.decimals as decimals, payment_system_id, sum(`amount`) as total_payout')
            ->groupBy('payment_systems.currency')
            ->get();

        foreach ($totalPayouts as $totalPayout) {
            if($totalPayout->currency != 'USD') {
                $exchangeRate = ExchangeRate::where('from', $totalPayout->currency)->first();
                $data['payoutSum'] += $totalPayout->total_payout * (json_decode($exchangeRate?->rate)?->USD ?? 1);
            } else {
                $data['payoutSum'] += $totalPayout->total_payout;
            }
            $data['payoutSum'] = round($data['payoutSum'], 2);
        }

        return view('admin.dashboard', $data);
    }
}
