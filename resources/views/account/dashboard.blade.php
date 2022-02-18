@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Dashboard',
        'description' => 'Welcome to your ' . config('app.name') . ' dashboard.'
    ])
    @include('account.__partials.nav')

    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="checkout-coupon">
                        <h6> Welcome back,
                            <span style="border: 0;">{{ $user->name }} </span>
                        </h6>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="checkout-coupon text-md-right">
                        <h6> Your upline:
                            <span style="border: 0;">{{ $user->referredBy->username ?? 'n/a' }} </span>
                        </h6>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-2">
                    <div class="quick-call">
                        <div class="mb-3"><span><i class="fas fa-download"></i></span></div>
                        <div class="qc-txt">
                            <p>Total Deposit</p>
                            <h4>≈{{ CustomHelper::formatAmount($totalDeposit, 2) }} USD</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-2">
                    <div class="quick-call">
                        <div class="mb-3"><span><i class="fas fa-upload"></i></span></div>
                        <div class="qc-txt">
                            <p>Total Withdraw</p>
                            <h4>≈{{ CustomHelper::formatAmount($totalPayout, 2) }} USD</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-2">
                    <div class="quick-call">
                        <div class="mb-3"><span><i class="fas fa-users"></i></span></div>
                        <div class="qc-txt">
                            <p>Referrals</p>
                            <h4>{{ $referrals }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-2">
                    <div class="quick-call">
                        <div class="mb-3"><span><i class="fas fa-wallet"></i></span></div>
                        <div class="qc-txt">
                            <p>Available balance</p>
                            <h4>≈{{ $balance }} USD</h4>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-intro mb-0 mt-3">
                        <h3 class="section-title">Your investments<span class="color">.</span></h3>
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
                        <th>Amount</th>
                        <th>Transaction ID</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($user->deposits))
                        @foreach($user->deposits as $deposit)
                            <tr>
                                <td>{{ $deposit->id }}</td>
                                <td><span
                                        class="badge bg-{{ CustomHelper::statusColor($deposit->status) }}">{{ ucfirst($deposit->status) }}</span>
                                </td>
                                <td>{{ $deposit->status == 'pending' ? $deposit->created_at : $deposit->confirmed_at }}</td>
                                <td>{{ CustomHelper::formatAmount($deposit->amount, $deposit->paymentSystem->decimals) }} {{ $deposit->paymentSystem->currency }}
                                    ({{ $deposit->paymentSystem->name }})
                                </td>
                                <td>{{ $deposit->transaction_id ?: 'Waiting for payment...' }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr colspan="5">
                            <td>Deposit list is empty</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
