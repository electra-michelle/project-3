<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payout;
use App\Models\UserAccount;
use App\Services\PayoutService;
use App\Services\StatisticsService;
use App\Services\WalletBalanceService;
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
     * @param PayoutService $payoutService
     * @param Payout $payout
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(PayoutService $payoutService, Payout $payout)
    {
        if($payout->status != 'pending') {
            return response()->json(['message' => 'Invalid status'], 422);
        }

        if($payout->paymentSystem->payouts_enabled) {
            return response()->json(['message' => 'Manual payouts are currently disabled.'], 422);
        }

        $payout = $payoutService->setAsPaid($payout->id, 123);

        return response()->json(['status' => 'success', 'transaction_id' => $payout->transaction_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel(WalletBalanceService $balanceService, Payout $payout)
    {

        if($payout->status != 'pending') {
            return response()->json(['message' => 'Invalid status'], 422);
        }

        $userAccount = UserAccount::firstOrCreate([
                'user_id' => $payout->user_id,
                'payment_system_id' =>  $payout->payment_system_id
            ]);

        $userAccount = $balanceService->addBalance($userAccount, $payout->amount, $payout->paymentSystem->decimals);

        $payout->status = 'cancelled';
        $payout->save();

        return response()->json(['status' => 'success']);
    }
}
