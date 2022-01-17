<?php

namespace App\Http\Controllers\Admin;

use App\Models\Deposit;
use App\Models\ExchangeRate;
use App\Models\PaymentSystem;
use App\Models\Payout;
use App\PaymentSystems\ePayCore;
use App\Services\CryptoNodeService;
use App\Http\Controllers\Controller;

class WalletBalancesController extends Controller
{

    /**
     * @param $paymentSystemId
     * @return mixed
     */
    private function getDepositCount($paymentSystemId)
    {
        return Deposit::where(fn($query) => (
            $query->where('status', 'active')
                ->orWhere('status', 'finished')
            )
        )
        ->where('payment_system_id', $paymentSystemId)
        ->count();
    }

    /**
     * @param null $paymentSystemId
     * @return mixed
     */
    private function getDepositSum($paymentSystemId)
    {
        return Deposit::where(fn($query) => (
            $query->where('status', 'active')
                ->orWhere('status', 'finished')
            )
        )
        ->where('payment_system_id', $paymentSystemId)
        ->sum('amount');
    }


    /**
     * @param null $paymentSystemId
     * @return mixed
     */
    private function getPayoutSum($paymentSystemId)
    {
        return Payout::where('status', 'paid')
        ->where('payment_system_id', $paymentSystemId)
        ->sum('amount');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $paymentSystems = PaymentSystem::active()->get();
        $walletData['all'] = [
            'deposits' => 0,
            'totalDeposit' => 0,
            'totalPayout' => 0,
            'balance' => 0
        ];


        foreach($paymentSystems as $paymentSystem)
        {
            $walletData[$paymentSystem->value] = [
                'deposits' => $this->getDepositCount($paymentSystem->id),
                'totalDeposit' => $this->getDepositSum($paymentSystem->id),
                'totalPayout' => $this->getPayoutSum($paymentSystem->id),
                'balance' => 0
            ];

            switch ($paymentSystem->value) {
                case 'epaycore':
                    $epayCore = new ePayCore();
                    $walletData[$paymentSystem->value]['balance'] = $epayCore->getBalance();
                    break;
                case 'bitcoin':
                case 'bitcoincash':
                case 'dash':
                case 'litecoin':

                    $nodeService = new CryptoNodeService($paymentSystem->value);
                    $walletData[$paymentSystem->value]['balance'] = $nodeService->getBalance();
                    break;
                default:
                    $walletData[$paymentSystem->value]['balance'] = 0;
            }

            if($paymentSystem->currency != 'USD') {
                $exchangeRate = ExchangeRate::where('from', $paymentSystem->currency)->first();
                $convertedBalance = $walletData[$paymentSystem->value]['balance'] * (json_decode($exchangeRate->rate)->USD ?? 1);
            }

            $walletData['all']['balance'] += $convertedBalance ?? $walletData[$paymentSystem->value]['balance'];
            $walletData['all']['deposits'] += $walletData[$paymentSystem->value]['deposits'];
            $walletData['all']['totalDeposit'] += $walletData[$paymentSystem->value]['totalDeposit'];
            $walletData['all']['totalPayout'] += $walletData[$paymentSystem->value]['totalPayout'];

        }

        return view('admin.balances.balances', compact('paymentSystems', 'walletData'));
    }

}
