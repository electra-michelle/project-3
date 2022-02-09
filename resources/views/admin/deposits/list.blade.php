@extends('adminlte::page')

@section('title', 'Deposits')
@section('plugins.Sweetalert2', true)

@section('content_header')
    <h1 class="m-0 text-dark">Deposits</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <x-adminlte-info-box title="Deposit Count" text="{{ $depositsCount }}" icon="fas fa-lg fas fa-chart-line"
                                 icon-theme="info"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Total Deposited" text="≈{{ CustomHelper::formatAmount($depositSum, 2) }} USD"
                                 icon="fas fa-lg fa-upload" icon-theme="purple"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Active deposits"
                                 text="≈{{ CustomHelper::formatAmount($activeDeposits, 2) }} USD"
                                 icon="fas fa-lg fa-business-time" icon-theme="success"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Finished Deposits"
                                 text="≈{{ CustomHelper::formatAmount($finishedDeposits, 2) }} USD"
                                 icon="fas fa-lg fa-wallet" icon-theme="secondary"/>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(session()->has('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
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
                                        <td><span
                                                class="badge badge-{{ CustomHelper::statusColor($deposit->status) }}">{{ ucfirst($deposit->status) }}</span>
                                        </td>
                                        <td>{{ $deposit->plan->name }} <small>({{ $deposit->period_passed }}
                                                /{{ $deposit->plan_period_max_period_end }})</small></td>
                                        <td>
                                            {{ CustomHelper::formatAmount($deposit->amount, $deposit->paymentSystem->decimals) }} {{ $deposit->paymentSystem->currency }}
                                            <small>({{ $deposit->paymentSystem->name }})</small>
                                        </td>
                                        <td><a target="_blank"
                                               href="{{ route('admin.users.show', $deposit->user_id) }}">{{ $deposit->user->username }}</a>
                                        </td>
                                        <td>
                                            @if($deposit->status == 'pending')
                                                <a class="btn btn-sm btn-success"
                                                   href="{{ route('admin.deposits.edit', $deposit->id) }}">Accept</a>
                                                <button data-id="{{ $deposit->id }}"
                                                        class="btn btn-sm btn-danger cancel">Cancel
                                                </button>
                                            @else
                                                <a class="btn btn-sm btn-info"
                                                   href="{{ route('admin.deposits.show', $deposit->id) }}">View
                                                    details</a>
                                            @endif
                                        </td>
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
@push('js')
    <script>
        $(document).ready(function () {
            $('.cancel').click(function () {
                var depositId = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure to cancel deposit request #' + depositId + '?',
                    text: 'Deposit #' + depositId + ' will be cancelled.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel it!',
                    cancelButtonText: 'Close'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete('/felicita/deposits/' + depositId, {}).then((response) => {
                            Swal.fire({
                                title: 'Cancelled!',
                                text: 'Deposit #' + depositId + ' has been cancelled.',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload()
                                }
                            })
                        }).catch((error) => {
                            Swal.fire({
                                title: 'Whoops! Something went wrong!',
                                text: 'Unable to cancel withdraw request #' + depositId + '. Message: ' + error.response.data.message,
                                icon: 'error'
                            })
                        });
                    }
                })
            });
        })
    </script>
@endpush
