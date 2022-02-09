<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CustomHelper;
use App\Http\Requests\Admin\ConfirmDepositRequest;
use App\Models\Deposit;
use App\Models\PlanLimit;
use App\Services\DepositService;
use App\Services\StatisticsService;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Deposit $deposit)
    {
        $deposit->load(['plan' => fn($query) => (
            $query->withMax('periods', 'period_end')
        )]);

        return view('admin.deposits.details', compact('deposit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Deposit $deposit)
    {
        abort_if($deposit->status != 'pending', 404);
        return view('admin.deposits.confirm', compact('deposit'));
    }

    /**
     * @param DepositService $depositService
     * @param ConfirmDepositRequest $request
     * @param Deposit $deposit
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(DepositService $depositService, ConfirmDepositRequest $request, Deposit $deposit)
    {
        abort_if($deposit->status != 'pending', 404);

        $planLimit = PlanLimit::where('plan_id', $deposit->plan_id)
            ->where('currency', $deposit->paymentSystem->currency)
            ->first();

        $rules = ['amount' => [
            'numeric', 'regex:/^\d*(\.\d{1,' . $deposit->paymentSystem->decimals . '})?$/',
        ]];

        if($planLimit->min_amount != -1) {
            $rules['amount'][] = 'min:' . CustomHelper::formatAmount($planLimit->min_amount, $deposit->paymentSystem->decimals);
        }

        if($planLimit->max_amount != -1) {
            $rules['amount'][] = 'max:' . CustomHelper::formatAmount($planLimit->max_amount, $deposit->paymentSystem->decimals);
        }

        $request->validate($rules);

        $deposit->fill($request->only(['amount', 'comment']));
        $deposit = $depositService->acceptDeposit($deposit, $request->input('transaction_id'));

        return redirect()
            ->route('admin.deposits')
            ->with(['success' => 'Deposit #' . $deposit->id . ' has been confirmed.']);

    }

    /**
     * @param Deposit $deposit
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Deposit $deposit)
    {
        abort_if($deposit->status != 'pending', 404);

        $deposit->status = 'cancelled';
        $deposit->save();

        return response()->json(['status' => 'success']);
    }

}
