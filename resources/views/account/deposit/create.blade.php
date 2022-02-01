@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Make deposit',
        'description' => '12321321'
    ])
    @include('account.__partials.nav')

    <section class="section-padding">
        <div class="container">
            <form action="{{ route('account.deposit') }}" method="POST">
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <div class="input-group">
                                <input id="amount" type="text" class="form-control" name="amount" value="{{ old('amount', request()->input('amount')) }}">
                                <div class="input-group-text">USD</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="amount">Investment plan</label>
                            <select name="investment_plan" class="form-control">
                                @foreach($plans as $plan)
                                    <option {{ old('investment_plan', request()->input('investment_plan')) == $plan->value ? 'selected' : '' }} value="{{ $plan->value }}">{{ $plan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="payment_method">Payment method</label>
                            <select id="payment_method" name="payment_method" class="form-control">
                                <option {{ old('payment_method') == 'payment_processor' ? 'selected' : ''}} value="payment_processor">By Payment Processor</option>
                                <option {{ old('payment_method') == 'account_balance' ? 'selected' : ''}} value="account_balance">By Account Balance</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="amount">Payment System</label>
                            <select name="payment_system" class="form-control">
                                @foreach($paymentSystems as $paymentSystem)
                                    <option {{ old('payment_system', request()->input('payment_system')) == $paymentSystem->value ? 'selected' : '' }} value="{{ $paymentSystem->value }}">{{ $paymentSystem->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <button type="submit" class="custom-btn">Make Investment</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
