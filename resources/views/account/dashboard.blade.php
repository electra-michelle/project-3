@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Dashboard',
        'description' => '12321321'
    ])
    @include('account.__partials.nav')

    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-3">
                    @include('account.__partials.ref_link')
                </div>
                <div class="col-lg-6 mb-2">
                    <div class="quick-call">
                        <div class="mb-3"><span><i class="fas fa-users"></i></span></div>
                        <div class="qc-txt">
                            <p>Total Referrals</p>
                            <h4>123</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2">
                    <div class="quick-call">
                        <div class="mb-3"><span><i class="fas fa-user-check"></i></span></div>
                        <div class="qc-txt">
                            <p>Active Referrals</p>
                            <h4>345</h4>
                        </div>
                    </div>
                </div>
            </div>
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
                        @foreach($user->deposits as $deposit)
                            <tr>
                                <td>{{ $deposit->id }}</td>
                                <td><span class="badge bg-{{ CustomHelper::statusColor($deposit->status) }}">{{ ucfirst($deposit->status) }}</span></td>
                                <td>{{ $deposit->status == 'pending' ? $deposit->created_at : $deposit->confirmed_at }}</td>
                                <td>{{ CustomHelper::formatAmount($deposit->amount, $deposit->paymentSystem->decimals) }} {{ $deposit->paymentSystem->currency }} ({{ $deposit->paymentSystem->name }})</td>
                                <td>{{ $deposit->transaction_id ?: 'Waiting for payment...' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
