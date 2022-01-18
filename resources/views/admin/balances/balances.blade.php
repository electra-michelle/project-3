@extends('adminlte::page')

@section('title', 'Balances')

@section('content_header')
    <h1 class="m-0 text-dark">Wallet Balances</h1>
@stop


@section('content')
    <div class="card card-primary card-outline card-tabs">
        <div class="card-header p-0 pt-1 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="all-tab" data-toggle="pill" href="#all-content" role="tab" aria-controls="all-content" aria-selected="true">All</a>
                </li>
                @foreach($paymentSystems as $paymentSystem)
                    <li class="nav-item">
                        <a class="nav-link" id="{{ $paymentSystem->value }}-tab" data-toggle="pill" href="#{{ $paymentSystem->value }}-content" role="tab" aria-controls="{{ $paymentSystem->value }}-content" aria-selected="true">{{ $paymentSystem->name }} </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-two-tabContent">
                @include('admin.balances.tab', ['key' => 'all', 'currency' => 'USD'])
                @foreach($paymentSystems as $paymentSystem)
                    @include('admin.balances.tab', ['key' => $paymentSystem->value, 'currency' => $paymentSystem->currency])
                @endforeach
            </div>
        </div>
        <!-- /.card -->
    </div>
@stop

@section('plugins.Momentjs', true)
@section('plugins.Chartjs', true)

@section('js')
    <script>
        $(document).ready(function () {

            @foreach($charts as $chartKey => $chart)
            var {{ $chartKey }}WalletBalance = {!! json_encode($chart['balance'])!!};
            new Chart(document.getElementById("{{ $chartKey }}WalletBalance"), {
                "type":"line",
                "data": {
                    "datasets":[ {
                        "label": "Wallet Balance in {{ $chart['currency'] }}",
                        "data": {{ $chartKey }}WalletBalance,
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
