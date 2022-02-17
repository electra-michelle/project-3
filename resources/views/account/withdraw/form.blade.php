@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Withdraw',
        'description' => 'Ready to withdraw your earnings?'
    ])
    @include('account.__partials.nav')

    <section class="section-padding">
        <div class="container">
            <div class="row">
                @foreach($paymentSystems as $paymentSystem)
                    <div class="col-lg-4 col-md-6 mb-2 wallets">
                        <div class="quick-call">
                            <div class="mb-3"><img style="height: 50px" src="/ps/{{$paymentSystem->value }}.png"
                                                   alt="{{$paymentSystem->name }}"/></div>
                            <div class="qc-txt">
                                <p>Available balance</p>
                                <h4>{{ CustomHelper::formatAmount($paymentSystem->balance ?? 0, $paymentSystem->decimals) }} {{ $paymentSystem->currency }}</h4>
                                <small class="break-all">{!!  $paymentSystem->wallet ?? '<a href="' . route('account.settings')  . '">set up</a>' !!}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <form action="{{ route('account.withdraw') }}" method="POST" id="withdrawForm" class="mt-3">
                @csrf
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
                @if(session()->has('withdraw_success'))
                    <div class="alert alert-success">{{ session('withdraw_success') }}</div>
                @endif
                <div class="row">
                        <div class="form-group col-md-4">
                            <label for="payment_system">Payment System</label>
                            <select id="payment_system" name="payment_system" class="form-control">
                                @foreach($paymentSystems as $paymentSystem)
                                    <option data-currency="{{ $paymentSystem->currency }}"
                                        {{ old('payment_system') == $paymentSystem->value ? ' selected' : '' }} value="{{ $paymentSystem->value }}">{{ $paymentSystem->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="amount">Amount</label>
                            <div class="input-group">
                                <input id="amount" type="text" class="form-control" name="amount"
                                       value="{{ old('amount') }}">
                                <div id="currency" class="input-group-text">USD</div>
                            </div>
                        </div>
                        <div class="form-group  col-md-4 align-self-end">
                            <button type="submit" class="custom-btn w-100">Withdraw</button>
                        </div>
                </div>
            </form>
            <hr class="my-4"/>
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-intro mb-0">
                        <h3 class="section-title">Withdraw History<span class="color">.</span></h3>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Transaction ID</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($payouts))
                        @foreach($payouts as $payout)
                            <tr>
                                <td>{{ $payout->id }}</td>
                                <td><span
                                        class="badge bg-{{ $payout->status == 'paid' ? 'success' : 'warning' }}">{{ ucfirst($payout->status) }}</span>
                                </td>
                                <td>{{ $payout->status == 'pending' ? $payout->created_at : $payout->paid_at }}</td>
                                <td>{{ CustomHelper::formatAmount($payout->amount, $payout->paymentSystem->decimals) }} {{ $payout->paymentSystem->currency }}
                                    ({{ $payout->paymentSystem->name }})
                                </td>
                                <td>{{ $payout->transaction_id }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="5">Transactions not found</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>

            {{ $payouts->links('layouts.pagination') }}
        </div>
    </section>
@endsection

@section('js')
    <script>
        function setCurrency() {
            var currency =  $('#payment_system option:selected').data('currency');
            $("#currency").text(currency);
        }
        setCurrency();

        $("#payment_system").on('change', function() {
            setCurrency()
        })
    </script>
@endsection
