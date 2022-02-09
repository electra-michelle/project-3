@extends('adminlte::page')

@section('title', 'Deposits')

@section('content_header')
    <h1 class="m-0 text-dark">Deposit details #{{ $deposit->id }}</h1>
@stop

@section('content')

    <!-- LINE CHART -->
    <div class="card">
        <div class="card-body">
            @if(session()->has('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <h6 class="text-bold">Period passed ({{ $deposit->period_passed }}/{{ $deposit->plan->periods_max_period_end }}): </h6>
            <x-adminlte-progress theme="green" value="{{ (int)round(($deposit->period_passed/$deposit->plan->periods_max_period_end)*100) }}" animated/>
            <div class="table-responsive mt-3">
                <table class="table table-striped">
                    <tr>
                        <td>Status:</td>
                        <td>
                            <span
                                class="badge badge-{{ CustomHelper::statusColor($deposit->status) }}">{{ ucfirst($deposit->status) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Date:</td>
                        <td>
                            {{ $deposit->created_at }}
                        </td>
                    </tr>
                    <tr>
                        <td>User:</td>
                        <td>
                            <a target="_blank"
                               href="{{ route('admin.users.show', $deposit->user->id) }}">{{ $deposit->user->username }}</a>
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
                    <tr>
                        <td>Amount:</td>
                        <td>
                            {{ CustomHelper::formatAmount($deposit->amount, $deposit->paymentSystem->decimals) }} {{ $deposit->paymentSystem->currency }}
                        </td>
                    </tr>
                    <tr>
                        <td>Transaction ID:</td>
                        <td>
                            {{ $deposit->transaction_id }}
                        </td>
                    </tr>
                    <tr>
                        <td>Comment:</td>
                        <td>
                            {{ $deposit->comment }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        </form>
    </div>
    <!-- /.card -->
@stop
