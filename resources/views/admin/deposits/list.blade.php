@extends('adminlte::page')

@section('title', 'Deposits')

@section('content_header')
    <h1 class="m-0 text-dark">Deposits</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <x-adminlte-info-box title="Deposit Count" text="{{ $depositsCount }}" icon="fas fa-lg fas fa-chart-line" icon-theme="info"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Total Deposited" text="≈{{ $depositSum }} USD" icon="fas fa-lg fa-upload" icon-theme="purple"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Active deposits" text="≈{{ $activeDeposits }} USD" icon="fas fa-lg fa-business-time" icon-theme="success"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Finished Deposits" text="≈{{ $finishedDeposits }} USD" icon="fas fa-lg fa-wallet" icon-theme="secondary"/>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>User</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($deposits))
                            @foreach($deposits as $deposit)
                                <tr>
                                    <td>{{ $deposit->id }}</td>
                                    <td>
                                        @if($deposit->status == 'active' || $deposit->status == 'finished')
                                            {{ $deposit->confirmed_at->diffForHumans() }}
                                        @else
                                            {{ $deposit->created_at->diffForHumans() }}
                                        @endif
                                    </td>
                                    <td><span class="badge badge-{{ CustomHelper::statusColor($deposit->status) }}">{{ ucfirst($deposit->status) }}</span></td>
                                    <td>{{ $deposit->plan->name }} <small>({{ $deposit->period_passed }}/{{ $deposit->plan_period_max_period_end }})</small></td>
                                    <td>
                                        {{ CustomHelper::formatAmount($deposit->amount, $deposit->paymentSystem->decimals) }} {{ $deposit->paymentSystem->currency }} <small>({{ $deposit->paymentSystem->name }})</small>
                                    </td>
                                    <td><a target="_blank" href="{{ route('admin.users.show', $deposit->user_id) }}">{{ $deposit->user->username }}</a></td>
                                    <td></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">Deposit list is empty</td>
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
