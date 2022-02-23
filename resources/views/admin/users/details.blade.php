@extends('adminlte::page')

@section('title', 'User details')
@section('plugins.Sweetalert2', true)

@section('content_header')
    <form action="{{ route('admin.users.login', $user->id) }}" method="POST">
        @csrf
        <button class="btn btn-success float-right">Login as user</button>
    </form>
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
        <div class="col-md-3">
            <!-- About Me Box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User data</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <strong><i class="fas fa-id-card mr-1"></i> Referred by</strong>
                            <p class="text-muted">
                                @if($user->upline)
                                    <a href="{{ route('admin.users.show', $user->upline) }}">{{ $user->referredBy->username }}</a>
                                @else
                                    n/a
                                @endif
                            </p><hr>
                        </div>
                        <div class="col-12">
                            <strong><i class="fas fa-envelope mr-1"></i> E-Mail</strong>
                            <p class="text-muted">
                                {{ $user->email }}
                            </p><hr>
                        </div>
                        <div class="col-12">
                            <strong><i class="fas fa-user mr-1"></i> Username</strong>
                            <p class="text-muted">
                                {{ $user->username }}
                            </p><hr>
                        </div>
                        <div class="col-12">
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
            <!-- About Me Box -->
            <div class="card">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">User Wallets</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if(session()->has('wallets_success'))
                            <div class="alert alert-success">{{ session('wallets_success') }}</div>
                        @endif
                        @foreach($paymentSystems as $paymentSystem)
                            <x-adminlte-input name="{{ $paymentSystem->value }}"
                                              value="{{ old($paymentSystem->value, ($wallets[$paymentSystem->id] ?? null)) }}"
                                              label="{{ $paymentSystem->name }}"
                                              error-key="{{ $paymentSystem->value }}"/>
                        @endforeach
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#deposits" data-toggle="tab">Deposits</a></li>
                        <li class="nav-item"><a class="nav-link" href="#payouts" data-toggle="tab">Payouts</a></li>
                        <li class="nav-item"><a class="nav-link" href="#referrals" data-toggle="tab">Referrals</a></li>
                        <li class="nav-item"><a class="nav-link" href="#history" data-toggle="tab">History</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="deposits">
                            <x-adminlte-datatable id="table-deposits" :heads="['ID','Date','Status','Plan','Amount','Type','Action']">
                                @foreach($user->deposits as $deposit)
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
                                        <td>{{ ucfirst($deposit->payment_type) }}</td>
                                        <td>
                                            @include('admin.deposits.__partials.actions')
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                        <div class="tab-pane" id="payouts">
                            <x-adminlte-datatable id="table-payouts" :heads="['ID','Date','Status', 'Amount','Action']">
                                @foreach($user->payouts as $payout)
                                    <tr>
                                        <td>{{ $payout->id }}</td>
                                        <td>
                                            @if($payout->status == 'paid')
                                                {{ $payout->paid_at->diffForHumans() }}
                                            @else
                                                {{ $deposit->created_at->diffForHumans() }}
                                            @endif
                                        </td>
                                        <td><span class="badge badge-{{ CustomHelper::statusColor($payout->status) }}">{{ ucfirst($payout->status) }}</span></td>
                                        <td>
                                            {{ CustomHelper::formatAmount($payout->amount, $payout->paymentSystem->decimals) }} {{ $payout->paymentSystem->currency }} <small>({{ $payout->paymentSystem->name }})</small>
                                        </td>
                                        <td>
                                            {{ $payout->transaction_id ?: 'N/a' }}
                                        </td>
                                        <td>
                                            @include('admin.payouts.__partials.actions', ['payout' => $payout])
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                        <div class="tab-pane" id="referrals">
                            <x-adminlte-datatable id="table-referrals" :heads="['ID','Joined','Username', 'E-Mail', 'Has Deposits', 'Action']" :config="['ordering' => false]">
                                @foreach($user->referrals as $referral)
                                    <tr>
                                        <td>{{ $referral->id }}</td>
                                        <td>{{ $referral->created_at->diffForHumans() }}</td>
                                        <td><a target="_blank" href="{{ route('admin.users.show', $referral->id) }}">{{ $referral->username }}</a></td>
                                        <td>{{ $referral->email }}</td>
                                        <td><i class="far {{ $referral->deposits_sum_amount > 0 ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i></td>
                                        <td>
                                            <a target="_blank" href="{{ route('admin.users.show', $referral->id) }}" type="button" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                        <div class="tab-pane" id="history">
                            <x-adminlte-datatable id="table-history" :heads="['ID','Date','Action']" :config="['ordering' => false]">
                                @foreach($user->histories as $history)
                                    <tr>
                                        <td>{{ $history->id }}</td>
                                        <td>{{ $history->created_at->diffForHumans() }}</td>
                                        <td>{!! trans('adminlte::histories.' . $history->action, json_decode($history->data, true) ?? [])  !!}</td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    @include('admin.deposits.__partials.action_scripts')
    @include('admin.payouts.__partials.action_scripts')
@endpush
