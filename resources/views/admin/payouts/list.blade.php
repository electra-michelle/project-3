@extends('adminlte::page')

@section('title', 'Payouts')
@section('plugins.Sweetalert2', true);

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
                                    <td>{{ $payout->status == 'paid' ? $payout->transaction_id : 'Processing...' }}</td>
                                    <td>
                                        @if($payout->status == 'pending')
                                            <button data-id="{{ $payout->id }}" class="btn btn-sm btn-success send">Send</button>
                                            <button data-id="{{ $payout->id }}" class="btn btn-sm btn-danger cancel">Cancel</button>
                                        @endif
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
    <script>
        $(document).ready(function() {
            $('.cancel').click(function() {
                var payoutId = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure to cancel withdraw request #' + payoutId + '?',
                    text: "Withdrawal request amount will be added to users account balance.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel it!',
                    cancelButtonText: 'Close'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete('/felicita/payouts/' + payoutId, {}).then((response) => {
                            Swal.fire({
                                title: 'Cancelled!',
                                text: 'Payout #' + payoutId + ' has been cancelled and funds has been returned to users available balance.',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload()
                                }
                            })
                        }).catch((error) => {
                            Swal.fire({
                                title: 'Whoops! Something went wrong!',
                                text: 'Unable to cancel withdraw request #' + payoutId + '. Message: ' + error.response.data.message,
                                icon: 'error'
                            })
                        });
                    }
                })
            });

            $('.send').click(function() {
                var payoutId = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure to process payout #' + payoutId + '?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Close'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.patch('/felicita/payouts/' + payoutId, {}).then((response) => {
                            Swal.fire({
                                title: 'PAID!',
                                text: 'Payout #' + payoutId + ' has been processed with transaction id: ' +  response.data.transaction_id,
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload()
                                }
                            })
                        }).catch((error) => {
                            Swal.fire({
                                title: 'Whoops! Something went wrong!',
                                text: 'Unable to cancel withdraw request #' + payoutId + '. Message: ' + error.response.data.message,
                                icon: 'error'
                            })
                        });
                    }
                })
            });
        })
    </script>
@endpush
