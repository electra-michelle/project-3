<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\ExchangeRate;

class ReferralController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = auth()->user();

        $referrals = $user->referrals()
            ->latest()
            ->paginate(15);

        $totalReferrals = $user->referrals()
            ->count();

        $activeReferrals = $user->referrals()
            ->whereHas('deposits', fn($query) => (
                $query->where('status', 'active')
                    ->orWhere('status', 'finished')
                ))
            ->count();

        $histories = $user->histories()
            ->where('action', 'commission_earned')
            ->get();

        $exchangeRates = ExchangeRate::get()->pluck('rate', 'from');
        $earnedCommission = 0;
        foreach ($histories as $history) {
            $data = json_decode($history->data);
            $rate = json_decode($exchangeRates[$data->currency] ?? [], true);
            $earnedCommission += $data->currency == 'USD' ? $data->amount : ($data->amount * $rate['USD'] ?? 1);
        }

        $earnedCommission = round($earnedCommission, 2);

        return view('account.referrals', compact('referrals', 'totalReferrals', 'activeReferrals', 'earnedCommission'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function banners()
    {
        return view('account.banners');
    }
}
