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
                                    <td>{{ $deposit->plan->name }}</td>
                                    <td>
                                        {{ CustomHelper::formatAmount($deposit->amount, $deposit->paymentSystem->decimals) }} {{ $deposit->paymentSystem->currency }} <small>({{ $deposit->paymentSystem->name }})</small>
                                    </td>
                                    <td><a target="_blank" href="{{ route('admin.users.show', $deposit->user_id) }}">{{ $deposit->user->username }}</a></td>
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
                @if($deposits->hasPages())
                    <div class="card-footer">
                        {{ $deposits->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
