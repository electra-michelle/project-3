@extends('adminlte::page')

@section('title', 'User details')

@section('content_header')
    <h1 class="m-0 text-dark">User details</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <x-adminlte-info-box title="Total deposit" text="Soon" icon="fas fa-lg fa-upload" icon-theme="green"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Total Withdraw" text="123" icon="fas fa-lg fa-download" icon-theme="red"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Available balance" text="soon" icon="fas fa-lg fa-wallet" icon-theme="purple"/>
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
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
@stop
