@extends('adminlte::page')

@section('title', 'Payouts')

@section('content_header')
    <h1 class="m-0 text-dark">Payouts</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Method</th>
                            <th>Wallet</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($payouts))
                            @foreach($payouts as $payout)
                                <tr>
                                    <td>{{ $payout->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.payouts.view', $payout->id) }}">{{ $payout->paymentSystem->name }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.payouts.view', $payout->id) }}">????</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.payouts.view', $payout->id) }}">
                                            {{ CustomHelper::formatAmount($payout->amount, $payout->paymentSystem->decimals) }} {{ $payout->paymentSystem->currency }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">Payout list is empty</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                @if($payouts->hasPages())
                    <div class="card-footer">
                        {{ $payouts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
