<?php

namespace App\Http\Controllers\Api;

use App\Models\Deposit;
use App\PaymentSystems\ePayCore;
use App\Services\DepositService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ePayCoreController extends Controller
{

    public function __construct(private ePayCore $ePayCore, private DepositService $depositService) {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function accept(Request $request)
    {

        # run only if epc_batch && epc_sign provided
        if(!$request->has(['epc_batch', 'epc_sign'])) {
            abort(404);
        }

        # get sha256 signature
        $sign = $this->ePayCore->generateHash($request);

        # if signature not valid
        if($request->input('epc_sign') !== $sign) {
            abort(400);
        }

        $deposit = Deposit::where('status', 'pending')
            ->findOrFail($request->input('epc_order_id'));

        if(round($deposit->amount, 2) == round($request->input('epc_amount'), 2)) {
            $this->depositService->acceptDeposit($deposit, $request->input('epc_batch'));
        }

        # if signature valid
        return $request->input('epc_batch');
    }
}
