@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Make deposit',
        'description' => '12321321'
    ])
    @include('account.__partials.nav')

    <section class="section-padding">
        <div class="container">
            Details of {{ $deposit->id }}
            @if(in_array($deposit->paymentSystem->value, array_keys(config('crypto'))))
                <img src="data:image/png;base64, {!! base64_encode(QrCode::style('round')->format('png')->size(200)->generate( CustomHelper::formatDepositAddress($deposit->deposit_address, $deposit->paymentSystem->value))) !!} " />
			@elseif(in_array($deposit->paymentSystem->value, config('paykassa.crypto')))
				
                <img src="data:image/png;base64, {!! base64_encode(QrCode::style('round')->format('png')->size(200)->generate($deposit->deposit_address)) !!} " />
            @else
                @switch($deposit->paymentSystem->value)
                    @case('epaycore')
                        {{ \App\PaymentSystems\ePayCore::renderForm($deposit->amount, $deposit->id) }}
                        @break
                @endswitch
            @endif
        </div>
    </section>
@endsection
