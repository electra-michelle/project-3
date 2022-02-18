@if($deposit->transaction_id)
    <div class="alert alert-info">Your transaction has been received. Waiting for blockchain network confirmation.</div>
@else
    <div class="alert alert-warning">Send <u>exactly</u> <strong>{{ CustomHelper::formatAmount($deposit->amount, $deposit->paymentSystem->decimals) }} {{ $deposit->paymentSystem->currency }}</strong> to <strong>{{ $deposit->deposit_address }}</strong> {{ $deposit->paymentSystem->name }} address. Your deposit will be accepted automatically after blockchain network confirmation.</div>
    <div class="text-center mb-2">
        <img src="data:image/png;base64, {!! base64_encode(QrCode::style('round')->format('png')->size(200)->generate($imageDepositAddress . '?amount=' . CustomHelper::formatAmount($deposit->amount, $deposit->paymentSystem->decimals))) !!} "/>
    </div>
@endif
