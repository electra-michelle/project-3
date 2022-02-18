@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Make deposit',
        'description' => 'Best time to invest in your future'
    ])
    @include('account.__partials.nav')

    <section class="section-padding">
        <div class="container">
            <form id="depositForm" action="{{ route('account.deposit') }}" method="POST">
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="deposit-form mb-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="investment_plan">Investment plan</label>
                                        <select id="investment_plan" name="investment_plan" class="form-control">
                                            @foreach($plans as $plan)
                                                <option
                                                    {{ old('investment_plan', request()->input('investment_plan')) == $plan->value ? 'selected' : '' }} value="{{ $plan->value }}">{{ $plan->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_method">Payment method</label>
                                        <select id="payment_method" name="payment_method" class="form-control">
                                            <option
                                                {{ old('payment_method') == 'payment_processor' ? 'selected' : ''}} value="payment_processor">
                                                By Payment Processor
                                            </option>
                                            <option
                                                {{ old('payment_method') == 'account_balance' ? 'selected' : ''}} value="account_balance">
                                                By Account Balance
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_system">Payment System</label>
                                        <select id="payment_system" name="payment_system" class="form-control">
                                            @foreach($paymentSystems as $paymentSystem)
                                                <option
                                                    data-currency="{{ $paymentSystem->currency }}"
                                                    {{ old('payment_system', request()->input('payment_system')) == $paymentSystem->value ? 'selected' : '' }} value="{{ $paymentSystem->value }}">{{ $paymentSystem->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <div class="input-group">
                                            <input id="amount" type="text" class="form-control" name="amount"
                                                   value="{{ old('amount', request()->input('amount')) }}">
                                            <div id="currency" class="input-group-text">USD</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button type="submit" class="custom-btn">Make Investment</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            @foreach($plans as $plan)
                                <div id="{{ $plan->value }}" class="col-12 mb-3 plan-preview">
                                    <div class="pricingTable pb-3">
                                        <div class="pricingTable-header py-4">
                                            <h3 class="heading">{{ $plan->name }}</h3>
                                            <div class="price-value"> {{ round($plan->periods_avg_interest, 2) }}% <span
                                                    class="month">{{ $plan->period_type }}</span></div>
                                            <div><strong class="month">for {{ $plan->periods_max_period_end }}
                                                    days</strong>
                                            </div>
                                        </div>
                                        <div class="pricing-content">
                                            <ul>
                                                @foreach($plan->limits->keyBy('currency') as $limit)
                                                    <li class="limits limit-{{ $limit->currency }} @if($loop->first) active @endif">
                                                        <b>Minimum:</b> {{ round($limit->min_amount, 8) }} {{ $limit->currency }}
                                                    </li>
                                                    <li class="limits limit-{{ $limit->currency }} @if($loop->first) active @endif">
                                                        <b>Maximum:</b> {{ round($limit->max_amount, 8) }} {{ $limit->currency }}
                                                    </li>
                                                @endforeach
                                                <li><b>Total
                                                        return:</b> {{ round($plan->periods_avg_interest*$plan->periods_max_period_end) }}
                                                    %
                                                </li>
                                                <li><b>Principals included</b></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('js')
    <script>
        function showCurrenctPlan() {
            var plan = $("#investment_plan option:selected").val();
            $('.plan-preview').addClass('d-none');
            $('#' + plan).removeClass('d-none');
        }
        function showCurrentLimits() {
            var currency = $('#payment_system option:selected').data('currency');
            $('#currency').text(currency);
            $('.limits').removeClass('active');
            $('.limit-' + currency).addClass('active');
        }

        $("#investment_plan").on('change', function () {
            showCurrenctPlan();
        });
        $("#payment_system").on('change', function () {
            showCurrentLimits()
        });
        showCurrenctPlan();
        showCurrentLimits()

    </script>

@endsection
