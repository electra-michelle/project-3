@extends('adminlte::page')

@section('title', 'Deposits')

@section('content_header')
    <h1 class="m-0 text-dark">Confirm Deposit #{{ $deposit->id }}</h1>
@stop

@section('content')

    <!-- LINE CHART -->
    <div class="card">
        <form action="{{ route('admin.deposits.update', $deposit->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="card-body">
                @if(session()->has('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <td>Date:</td>
                            <td>
                                {{ $deposit->created_at }}
                            </td>
                        </tr>
                        <tr>
                            <td>User:</td>
                            <td>
                                <a target="_blank" href="{{ route('admin.users.show', $deposit->user->id) }}">{{ $deposit->user->username }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Plan:</td>
                            <td>
                                {{ $deposit->plan->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>Payment System:</td>
                            <td>
                                {{ $deposit->paymentSystem->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>Deposit Address:</td>
                            <td>
                                {{ $deposit->deposit_address ?? 'N/a' }}
                            </td>
                        </tr>
                    </table>
                </div>
                <hr />
                <x-adminlte-input name="amount" label="Amount" value="{{ old('amount', CustomHelper::formatAmount($deposit->amount, $deposit->paymentSystem->decimals)) }}">
                    <x-slot name="appendSlot">
                        <div class="input-group-text">{{ $deposit->paymentSystem->currency }}</div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="transaction_id"
                                  value="{{ old('transaction_id') }}"
                                  label="Transaction ID" error-key="transaction_id"/>
                <x-adminlte-input name="comment"
                                  value="{{ old('comment') }}"
                                  label="Comment" error-key="comment"/>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Confirm</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
@stop
