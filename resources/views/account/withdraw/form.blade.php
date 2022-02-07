@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Referrals',
        'description' => '12321321'
    ])
    @include('account.__partials.nav')

    <section class="section-padding">
        <div class="container">
            <form action="{{ route('account.withdraw') }}" method="POST">
                @csrf
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
                @if(session()->has('withdraw_success'))
                    <div class="alert alert-success">{{ session('withdraw_success') }}</div>
                @endif
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <div class="input-group">
                                <input id="amount" type="text" class="form-control" name="amount"
                                       value="{{ old('amount') }}">
                                <div class="input-group-text">USD</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="payment_system">Payment System</label>
                            <select name="payment_system" class="form-control">
                                <option value="">Select</option>
                                @foreach($paymentSystems as $paymentSystem)
                                    <option
                                        {{ old('payment_system') == $paymentSystem->value ? 'selected' : '' }} value="{{ $paymentSystem->value }}">{{ $paymentSystem->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="custom-btn">Withdraw</button>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-intro">
                        <h3 class="section-title">Your withdrawals<span class="color">.</span></h3>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Payment System</th>
                        <th>Transaction ID</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($payouts))
                        @foreach($payouts as $payout)
                            <tr>
                                <td>{{ $payout->id }}</td>
                                <td>{{ $payout->status }}</td>
                                <td>{{ $payout->status == 'pending' ? $payout->created_at : $payout->paid_at }}</td>
                                <td>{{ $payout->paymentSystem->name }}</td>
                                <td>{{ $payout->transaction_id }}</td>
                                <td>{{ number_format($payout->amount, $payout->paymentSystem->decimals, '.', '' ) }} {{ $payout->paymentSystem->currency }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="6">Transactions not found</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>

            {{ $payouts->links('layouts.pagination') }}
        </div>
    </section>
@endsection
