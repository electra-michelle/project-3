<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExchangeRate;
use App\Models\PaymentSystem;
use App\PaymentSystems\ePayCore;
use App\Services\CryptoNodeService;
use App\Http\Controllers\Controller;
use App\Services\StatisticsService;

class WalletBalancesController extends Controller
{

    public function __construct(private StatisticsService $statisticsService)
    {}

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
                'deposits' => $this->statisticsService->getDepositCount($paymentSystem->id),
                'totalDeposit' => $this->statisticsService->getDepositSum($paymentSystem->id),
                'totalPayout' => $this->statisticsService->getPayoutSum($paymentSystem->id),
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
