@extends('adminlte::page')

@section('title', 'User details')

@section('content_header')
    <h1 class="m-0 text-dark">User details #{{ $user->id }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <x-adminlte-info-box title="Total deposit" text="≈{{ $totalDeposit }} USD" icon="fas fa-lg fa-upload" icon-theme="green"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Total Withdraw" text="≈{{ $totalPayout }} USD" icon="fas fa-lg fa-download" icon-theme="red"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Available balance" text="≈{{ $availableBalance }} USD" icon="fas fa-lg fa-wallet" icon-theme="purple"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Referrals" text="{{ $referralCount }}" icon="fas fa-lg fa-users" icon-theme="yellow"/>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <!-- About Me Box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User data</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong><i class="fas fa-id-card mr-1"></i> Referred by</strong>
                            <p class="text-muted">
                                @if($user->upline)
                                    <a href="{{ route('admin.users.show', $user->upline) }}">{{ $user->referredBy->username }}</a>
                                @else
                                    n/a
                                @endif
                            </p><hr>
                        </div>
                        <div class="col-md-6">
                            <strong><i class="fas fa-envelope mr-1"></i> E-Mail</strong>
                            <p class="text-muted">
                                {{ $user->email }}
                            </p><hr>
                        </div>
                        <div class="col-md-6">
                            <strong><i class="fas fa-user mr-1"></i> Username</strong>
                            <p class="text-muted">
                                {{ $user->username }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <strong><i class="fas fa-user mr-1"></i> Name</strong>
                            <p class="text-muted">
                                {{ $user->name }}
                            </p>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Deposits</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Plan</th>
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
                                        <td></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">User list is empty</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
