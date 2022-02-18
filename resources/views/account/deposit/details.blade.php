@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Make deposit',
        'description' => 'Best time to invest in your future'
    ])
    @include('account.__partials.nav')
    <section id="details" class="section-padding">
        <div class="container">
            <aside class="sidebar service-sidebar">
                <div class="widget link-widget">
                    <h3 class="widget-title full">Investment ID: #{{ $deposit->id }}</h3>
                    <ul>
                        <li><strong>Investment Status:</strong> <span
                                class="badge bg-{{ CustomHelper::statusColor($deposit->status) }}">{{ ucfirst($deposit->status) }}</span></li>
                        <li><strong>Investment Type:</strong> {{ $deposit->payment_type == 'invest' ? 'Investment' : 'Reinvestment' }}</li>
                        <li><strong>Transaction ID:</strong> {{ $deposit->status == 'pending' && !$deposit->transaction_id ? 'Waiting for payment...' : $deposit->transaction_id }}</li>
                        <li><strong>Investment Amount:</strong> {{ CustomHelper::formatAmount($deposit->amount, $deposit->paymentSystem->decimals) }} {{ $deposit->paymentSystem->currency }}</li>
                        <li><strong>Payment Method:</strong> <img style="height: 24px;" src="/ps/{{ $deposit->paymentSystem->value }}.png" alt="{{ $deposit->paymentSystem->name }}" /></li>
                        <li><strong>Investment Plan:</strong> {{ $deposit->plan->name }} </li>
                        <li><strong>Investment period:</strong> {{ $deposit->plan_period_max_period_end }} Calendar days</li>
                    </ul>
                </div>
                @if($deposit->status == 'pending')
                    @if(in_array($deposit->paymentSystem->value, array_keys(config('crypto'))) || in_array($deposit->paymentSystem->value, config('paykassa.crypto')))
                        @include('paymentsystems.crypto', [
                            'imageDepositAddress' => in_array($deposit->paymentSystem->value, array_keys(config('crypto'))) ? CustomHelper::formatDepositAddress($deposit->deposit_address, $deposit->paymentSystem->value) : $deposit->deposit_address
                        ])
                    @else
                        <div class="widget brochur-widget text-center">
                            @switch($deposit->paymentSystem->value)
                                @case('epaycore')
                                    {{ \App\PaymentSystems\ePayCore::renderForm($deposit->amount, $deposit->id) }}
                                        @break
                            @endswitch
                        </div>
                    @endif
                @else
                    <div class="widget brochur-widget">
                        <a href="{{ route('account.dashboard') }}" class="custom-btn full">Back to Dashboard</a>
                    </div>
                @endif
            </aside>
        </div>
    </section>
@endsection
