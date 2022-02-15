<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

class ReferralController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $referrals = auth()->user()->referrals()
            ->latest()
            ->paginate(15);

        $totalReferrals = auth()->user()->referrals()
            ->count();

        $activeReferrals = auth()->user()->referrals()
            ->whereHas('deposits', fn($query) => (
                $query->where('status', 'active')
                ->orWhere('status', 'finished')
            ))
            ->count();

        return view('account.referrals', compact('referrals', 'totalReferrals', 'activeReferrals'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function banners()
    {
        return view('account.banners');
    }
}
