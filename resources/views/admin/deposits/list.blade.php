@extends('adminlte::page')

@section('title', 'Deposits')

@section('content_header')
    <h1 class="m-0 text-dark">Deposits</h1>
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
                        @if(count($deposits))
                            @foreach($deposits as $deposit)
                                <tr>
                                    <td>{{ $deposit->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.payouts.view', $deposit->id) }}">{{ $deposit->paymentSystem->name }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.payouts.view', $deposit->id) }}">????</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.payouts.view', $deposit->id) }}">
                                            {{ number_format($deposit->amount, $deposit->paymentSystem->decimals, '.', '') }} {{ $deposit->paymentSystem->currency }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">User list is empty</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                @if($deposits->hasPages())
                    <div class="card-footer">
                        {{ $deposits->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
