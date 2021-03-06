@extends('adminlte::page')

@section('title', 'Payouts')
@section('plugins.Sweetalert2', true)

@section('content_header')
    <h1 class="m-0 text-dark">Payouts</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <x-adminlte-info-box title="Total Paid" text="≈{{ CustomHelper::formatAmount($payoutSum, 2) }} USD" icon="fas fa-lg fa-upload" icon-theme="red"/>
        </div>
        <div class="col-md-4">
            <x-adminlte-info-box title="Pending Withdraws" text="≈{{ CustomHelper::formatAmount($pendingPayouts, 2) }} USD" icon="fas fa-lg fa-business-time" icon-theme="yellow"/>
        </div>
        <div class="col-md-4">
            <x-adminlte-info-box title="In balances" text="≈{{ CustomHelper::formatAmount($inBalances, 2) }} USD" icon="fas fa-lg fa-wallet" icon-theme="info"/>
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
                            <th>Amount</th>
                            <th>User</th>
                            <th>Transaction ID</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($payouts))
                            @foreach($payouts as $payout)
                                <tr>
                                    <td>{{ $payout->id }}</td>
                                    <td>{{ $payout->status == 'paid' ? $payout->paid_at->diffForHumans() : $payout->created_at->diffForHumans() }}</td>
                                    <td><span class="badge badge-{{ CustomHelper::statusColor($payout->status) }}">{{ ucfirst($payout->status) }}</span></td>
                                    <td>
                                        {{ CustomHelper::formatAmount($payout->amount, $payout->paymentSystem->decimals) }} {{ $payout->paymentSystem->currency }} <small>({{ $payout->paymentSystem->name }})</small>
                                    </td>

                                    <td><a target="_blank" href="{{ route('admin.users.show', $payout->user_id) }}">{{ $payout->user->username }}</a></td>
                                    <td>
                                        {{ $payout->transaction_id ?: 'N/a' }}
                                    </td>
                                    <td>
                                        @include('admin.payouts.__partials.actions', ['payout' => $payout])
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">Payout list is empty</td>
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

@push('js')
    @include('admin.payouts.__partials.action_scripts')
@endpush
