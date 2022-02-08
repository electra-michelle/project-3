<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payout;
use App\Services\StatisticsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayoutController extends Controller
{
    /**
     * @param StatisticsService $statisticsService
     * @param null $status
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(StatisticsService $statisticsService, $status = null)
    {
        $payouts = Payout::latest()
            ->with(['paymentSystem', 'user'])
            ->when($status, fn($query) => (
                $query->where('status', $status)
            ))
            ->paginate(15);

        $payoutSum =  $statisticsService->convertedPayoutSum();
        $pendingPayouts =  $statisticsService->convertedPayoutSum(
            status: 'pending'
        );

        $inBalances = $statisticsService->convertedAvailableBalance();

        return view('admin.payouts.list', compact('payouts', 'payoutSum', 'pendingPayouts', 'inBalances'));
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
