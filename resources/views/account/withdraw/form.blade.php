@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Referrals',
        'description' => '12321321'
    ])
    @include('account.__partials.nav')

    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-intro">
                        <h3 class="section-title">Your withdrawals<span class="color">.</span></h3>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped" >
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Transaction ID</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($payouts))
                    @foreach($payouts as $payout)
                        <tr>
                            <td>#{{ $payout->id }}</td>
                            <td>{{ $payout->status == 'pending' ? $payout->created_at : $payout->paid_at }}</td>
                            <td>{{ $payout->status }}</td>
                            <td>{{ $payout->transaction_id }}</td>
                            <td>{{ number_format($payout->amount, $payout->paymentSystem->decimals, '.', '' ) }} {{ $payout->paymentSystem->currency }}</td>
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="5">Transactions not found</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>

            {{ $payouts->links('layouts.pagination') }}
        </div>
    </section>
@endsection
