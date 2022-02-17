@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-xl-2 col-lg-4">
            <x-adminlte-info-box title="Users" text="{{ $users }}" icon="fas fa-lg fa-users" icon-theme="purple"/>
        </div>
        <div class="col-xl-2 col-lg-4">
            <x-adminlte-info-box title="Unread Messages" text="{{ $messages }}" icon="fas fa-lg fa-envelope" icon-theme="secondary"/>
        </div>
        <div class="col-xl-2 col-lg-4">
            <x-adminlte-info-box title="In balances" text="≈{{ $inBalances }} USD" icon="fas fa-lg fa-wallet" icon-theme="info"/>
        </div>
        <div class="col-xl-2 col-lg-4">
            <x-adminlte-info-box title="Total deposit" text="≈{{ $depositSum }} USD" icon="fas fa-lg fa-download" icon-theme="green"/>
        </div>
        <div class="col-xl-2 col-lg-4">
            <x-adminlte-info-box title="Total withdraw" text="≈{{ $payoutSum }} USD" icon="fas fa-lg fa-upload" icon-theme="red"/>
        </div>
        <div class="col-xl-2 col-lg-4">
            <x-adminlte-info-box title="Pending Withdraws" text="≈{{ $pendingPayouts }} USD" icon="fas fa-lg fa-business-time" icon-theme="yellow"/>
        </div>
    </div>
	<div class="row">
		<div class="col-12">
			<div class="card">
                <div class="card-header">Latest deposits</div>
                <div class="card-body">
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
							@if(count($latestDeposits))
								@foreach($latestDeposits as $deposit)
									<tr>
										<td>{{ $deposit->id }}</td>
										<td>
											{{ $deposit->confirmed_at->diffForHumans() }}
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
											@include('admin.deposits.__partials.actions', ['deposit' => $deposit])
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
			</div>
		</div>
	</div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">User count</div>
                <div class="card-body">
                    <canvas id="total_accounts" height="150"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Deposit count</div>
                <div class="card-body">
                    <canvas id="deposit_count" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop

@section('plugins.Momentjs', true)
@section('plugins.Chartjs', true)

@section('js')
    <script>
        $(document).ready(function () {

            @foreach($charts as $chartKey => $chart)
            var {{ $chartKey }} = {!! json_encode($chart)!!};
            new Chart(document.getElementById("{{ $chartKey }}"), {
                "type":"line",
                "data": {
                    "datasets":[ {
                        "label": "{{ ucwords(str_replace('_', ' ', $chartKey))  }}",
                        "data": {{ $chartKey }},
                        "fill": false,
                        "borderColor": "rgb(75, 192, 192)",
                        "lineTension": 0.1
                    }
                    ]
                },
                "options":  {
                    scales: {
                        xAxes: [{
                            type: 'time'
                        }]
                    }
                }
            });
            @endforeach
        });
    </script>
@stop
