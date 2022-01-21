<?php

namespace App\Http\Controllers\Admin;

use App\Models\Deposit;
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
            ->get()
            ->reverse();

        $data['charts'] = [];
        foreach ($statistics as $statistic) {
            $data['charts'][$statistic->type][] = [
                'x' => $statistic->created_at,
                'y' => $statistic->value,
            ];
        }

        return view('admin.dashboard', $data);
    }
}
