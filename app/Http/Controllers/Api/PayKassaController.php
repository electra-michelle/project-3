<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentSystems\PayKassa\Sci as PayKassaSci;
use App\Models\Deposit;
use App\Services\DepositService;

class PayKassaController extends Controller
{


    public function __construct(private PayKassaSci $paykassa, private DepositService $depositService) {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function accept(Request $request)
    {
        if(!$request->has(['private_hash'])) {
            abort(404);
        }
		
		$responseStatus = $this->paykassa->checkPayment($request->input('private_hash'));
        if(!$request->has(['private_hash'])) {
            abort(404);
        }
		
        $deposit = Deposit::where('status', 'pending')
            ->findOrFail($responseStatus->order_id);

        if( 
			round($responseStatus->amount, $deposit->paymentSystem->decimals) == round($deposit->amount, $deposit->paymentSystem->decimals) &&
			$deposit->paymentSystem->currency == $responseStatus->currency &&
			$responseStatus->shop_id == config('paykassa.sci.id')
		) {
            $this->depositService->acceptDeposit($deposit, $responseStatus->hash);
			return $deposit->id . '|success';
        }


	   return 'fail';
    }
}
