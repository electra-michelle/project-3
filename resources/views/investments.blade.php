@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Investments',
        'description' => 'Earn your passive income now'
    ])

	@include('plans')
    <section id="calculator" class="testimonial section-padding">
        <img src="/images/dot-graphic.png" alt="" class="anim-img">
        <img src="/images/dot-graphic.png" alt="" class="anim-img anim-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-intro">
                        <h2 class="section-title">Calculate your income<span class="color">.</span></h2>
                        <p>You can use the calculator below to see your potential returns on your investment by selecting your preferred currency and investment plan.</p>
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
