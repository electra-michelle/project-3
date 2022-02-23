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
			->whereHas('paymentSystem', function ($query) {
				$query->where('value', 'perfect_money')
					->where('process_type', 'perfect_money');
			})
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
            $histories = $this->perfectMoney->getHistory(
                $timestamp->format('d'), $timestamp->format('m'),
                $timestamp->format('Y'), $timestamp->format('d'),
                $timestamp->format('m'), $timestamp->format('Y'),
                [
                    'payment_id' => $deposit->id,
                    'paymentsreceived' => true,
                    'batchfilter' => $request->input('PAYMENT_BATCH_NUM')
                ]
            );

            if ($histories['status'] == 'success') {

                /* ...insert some code to proccess valid payments here... */
                foreach ($histories['history'] as $history) {
                    if (
                        $history['batch'] == $request->input('PAYMENT_BATCH_NUM') &&
                        $history['payment_id'] == $request->input('PAYMENT_ID') &&
                        $history['type'] == 'Income' &&
                        $request->input('PAYEE_ACCOUNT') == $history['payee_account'] &&
                        $request->input('PAYMENT_AMOUNT') == $history['amount'] &&
                        $request->input('PAYMENT_UNITS') == $history['currency'] &&
                        $request->input('PAYER_ACCOUNT') == $history['payer_account']
                    ) {

                        $this->depositService->acceptDeposit($deposit, $request->input('PAYMENT_BATCH_NUM'));

                    }

                }


            }


        }

    }
}
