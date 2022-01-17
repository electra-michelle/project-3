<div class="tab-pane fade {{ $key == 'all' ? ' active show' : null }}" id="{{ $key }}-content" role="tabpanel" aria-labelledby="{{ $key }}-tab">
    <div class="row">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $walletData[$key]['deposit_count'] }}</h3>

                    <p>Deposit Count</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $walletData[$key]['total_deposit'] }}</h3>

                    <p>{{ $currency }} Deposited</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $walletData[$key]['total_payout'] }}</h3>

                    <p>{{ $paymentSystem->currency }} PAID OUT</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $walletData[$key]['balance'] }}</h3>

                    <p>{{ $currency }} in Wallet Balance</p>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-8">
            <canvas id="{{ $key }}WalletBalance" height="200"></canvas>
        </div>
    </div>
</div>
