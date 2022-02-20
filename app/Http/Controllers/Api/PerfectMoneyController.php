<?php

namespace App\Http\Controllers\Api;

use App\Models\Deposit;
use App\PaymentSystems\PerfectMoney;
use App\Services\DepositService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PerfectMoneyController extends Controller
{
    public function __construct(private PerfectMoney $perfectMoney, private DepositService $depositService) { }

    /**
     * @param Request $request
     * @return string|void
     */
    public function accept(Request $request)
    {
        $hash = $this->perfectMoney->generateHash($request);

        if ($hash != $request->input('V2_HASH')) {
            return 'ok';
        }

        $deposit = Deposit::where('status', 'pending')
            ->findOrFail($request->input('PAYMENT_ID'));

        if (!$deposit) {
            return 'ok';
        }


        if (
            round($request->input('PAYMENT_AMOUNT'), 2) == round($deposit->amount, 2) &&
            $request->input('PAYEE_ACCOUNT') == config('perfectmoney.marchant_id') &&
            $request->input('PAYMENT_UNITS') == config('perfectmoney.units')
        ) {

            $deposit->transaction_id = $request->input('PAYMENT_BATCH_NUM');
            $deposit->save();

            $timestamp = Carbon::createFromTimestamp($request->input('TIMESTAMPGMT'));
            $history = $this->perfectMoney->getHistory(
                $timestamp->format('d'), $timestamp->format('m'),
                $timestamp->format('Y'), $timestamp->format('d'),
                $timestamp->format('m'), $timestamp->format('Y'),
                [
                    'payment_id' => $deposit->id,
                    'paymentsreceived' => true,
                    'batchfilter' => $request->input('PAYMENT_BATCH_NUM')
                ]
            );

            if ($history['status'] == 'success') {

                /* ...insert some code to proccess valid payments here... */
                foreach ($history['history'] as $history_data) {
                    if (
                        $history_data['batch'] == $request->input('PAYMENT_BATCH_NUM') &&
                        $history_data['payment_id'] == $request->input('PAYMENT_ID') &&
                        $history_data['type'] == 'Income' &&
                        $request->input('PAYEE_ACCOUNT') == $history_data['payer_account'] &&
                        $request->input('PAYMENT_AMOUNT') == $history_data['amount'] &&
                        $request->input('PAYMENT_UNITS') == $history_data['currency'] &&
                        $request->input('PAYER_ACCOUNT') == $history_data['payee_account']
                    ) {

                        $this->depositService->acceptDeposit($deposit, $request->input('PAYMENT_BATCH_NUM'));

                    }

                }


            }


        }

    }
}
