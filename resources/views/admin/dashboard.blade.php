@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <x-adminlte-info-box title="Users" text="{{ $users }}" icon="fas fa-lg fa-users" icon-theme="purple"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Total deposit" text="Soon" icon="fas fa-lg fa-download" icon-theme="green"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Total withdraw" text="soon" icon="fas fa-lg fa-upload" icon-theme="red"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Unread Messages" text="{{ $messages }}" icon="fas fa-lg fa-envelope" icon-theme="yellow"/>
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
                        "label": "{{ $chartKey  }}",
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
