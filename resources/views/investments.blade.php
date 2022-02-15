@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Investments',
        'description' => 'You have questions? We have answers!'
    ])

    <section class="testimonial-2  section-padding">
        <img src="/images/testmonial-shape.png" alt="" class="anim-img">
        <img src="/images/testmonial-shape.png" alt="" class="anim-img anim-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-intro">
                        <h2 class="section-title">What Our Loving
                            Clients Saying<span class="color">.</span></h2>
                        <p>Lorem Ipsum available the majority have suffered alteration
                            in some form, by injected humour, or randomised.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center mb-5">
                    <div id="limits" class="btn-group btn-group-lg" role="group">
                        @foreach($paymentSystems->pluck('currency')->unique() as $currency)
                        <button type="button" class="btn btn-primary  @if($loop->first) active @endif">{{ $currency }}</button>
                        @endforeach
                    </div>
                </div>
                @foreach($plans as $plan)
                <div class="col-md-4">
                    <div class="pricingTable">
                        <div class="pricingTable-header">
                            <h3 class="heading">{{ $plan->name }}</h3>
                            <div class="price-value"> {{ round($plan->periods_avg_interest, 2) }}% <span class="month">{{ $plan->period_type }}</span></div>
                            <div><strong class="month">for {{ $plan->periods_max_period_end }} days</strong></div>
                        </div>
                        <div class="pricing-content">
                            <ul>
                                @foreach($plan->limits->keyBy('currency') as $limit)
                                    <li class="limits limit-{{ $limit->currency }} @if($loop->first) active @endif"><b>Minimum:</b> {{ round($limit->min_amount, 8) }} {{ $limit->currency }}</li>
                                    <li class="limits limit-{{ $limit->currency }} @if($loop->first) active @endif"><b>Maximum:</b> {{ round($limit->max_amount, 8) }} {{ $limit->currency }}</li>
                                @endforeach
                                <li><b>Affiliate commission:</b> {{ round($plan->affiliate_commission, 2) }}% </li>
                                <li><b>Total return:</b> {{ round($plan->periods_avg_interest*$plan->periods_max_period_end) }}% </li>
                                <li><b>Principals included</b></li>
                            </ul>
                        </div>
                        <div class="pricingTable-signup">
                            <a class="custom-btn" href="{{ route('account.deposit') }}">Make investment</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <section id="calculator" class="testimonial section-padding">
        <img src="/images/dot-graphic.png" alt="" class="anim-img">
        <img src="/images/dot-graphic.png" alt="" class="anim-img anim-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-intro">
                        <h2 class="section-title">Calculate your income<span class="color">.</span></h2>
                        <p>Lorem Ipsum available the majority have suffered alteration
                            in some form, by injected humour, or randomised.</p>
                    </div>
                </div>
            </div>
            <form action="{{ route('account.deposit') }}">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="payment_system">Investment Method</label>
                        <select id="payment_system" name="payment_system" class="form-control">
                            @foreach($paymentSystems as $paymentSystem)
                                <option data-currency="{{ $paymentSystem->currency }}" value="{{ $paymentSystem->value }}">{{ $paymentSystem->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <div class="input-group">
                            <input id="amount" name="amount" type="text" class="form-control">
                            <div class="input-group-append">
                                <span class="input-group-text" id="currency">USD</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="investment_plan">Investment Plan</label>
                        <select id="investment_plan" name="investment_plan" class="form-control">
                            @foreach($plans as $plan)
                                <option value="{{ $plan->value }}">{{ $plan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <hr />
            <div class="row calculator-data">
                <div class="col-lg-4">
                    <strong>Daily Return:</strong> <span id="daily-return">10 USD</span>
                </div>
                <div class="col-lg-4">
                    <strong>Total Return:</strong> <span id="total-return">10 USD</span>
                </div>
                <div class="col-lg-4">
                    <strong>Total profit:</strong> <span id="total-profit">10 USD</span>
                </div>
            </div>
            <div class="text-center pt-4">
                <button type="submit" class="custom-btn">Invest now</button>
            </div>
            </form>
        </div>
    </section>

@endsection
@section('js')
    {!! htmlScriptTagJsApi() !!}

    <script>
        $("#limits button").on('click', function() {
            $("#limits button").removeClass('active');
            $(this).addClass('active');
            var currency = $(this).text();

            $(".limits").removeClass('active');
            $(".limits.limit-" + currency).addClass('active');
        });

        var plansData = {!! CustomHelper::formatCalculatorJson($plans) !!};

        function calculate() {
            var currency =$('#payment_system option:selected').data('currency');
            var amount = parseFloat($('#amount').val());
            var investment_plan = $('#investment_plan option:selected').val();
            var planData = plansData[investment_plan];

            if(amount >= planData.limits[currency].min && amount <= planData.limits[currency].max ){
                var daily = Math.round(amount*planData.interest/100*planData.limits[currency].rounder)/planData.limits[currency].rounder;
                var total = Math.round(daily*planData.period*planData.limits[currency].rounder)/planData.limits[currency].rounder;
                var profit = Math.round((total-amount)*planData.limits[currency].rounder)/planData.limits[currency].rounder;
            } else {
                var daily = 'n/a';
                var total = 'n/a';
                var profit = 'n/a';
            }


            $('#currency').text(currency);
            $('#daily-return').text(daily + " " + currency);
            $('#total-profit').text(profit + " " + currency);
            $('#total-return').text(total + " " + currency);

        }

        $("#payment_system, #investment_plan").on('change', function () {
            calculate();
        });

        $("#amount").on('keyup', function () {
            calculate();
        });
    </script>
@endsection
