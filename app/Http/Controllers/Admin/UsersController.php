<?php

namespace App\Http\Controllers\Admin;

use App\Models\Deposit;
use App\Models\User;
use App\Services\StatisticsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = User::with('referredBy')
            ->latest()
            ->paginate(15);

        return view('admin.users.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(StatisticsService $statisticsService, User $user)
    {
        $referralCount = $user->referrals()->count();
        $deposits = $user->deposits()
            ->with(['paymentSystem', 'plan'])
            ->withMax('planPeriod', 'period_end')
            ->paginate(15);

        $totalDeposit = $statisticsService->convertedDepositSum($user->id);
        $totalPayout = $statisticsService->convertedPayoutSum($user->id);
        $availableBalance = $statisticsService->convertedAvailableBalance($user->id);

        return view('admin.users.details', compact('user', 'referralCount', 'deposits', 'totalDeposit', 'totalPayout', 'availableBalance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
