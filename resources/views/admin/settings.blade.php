@extends('adminlte::page')

@section('title', 'Settings')

@section('content_header')
    <h1 class="m-0 text-dark">Settings</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(session()->has('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('admin.settings') }}" method="POST">
                        @csrf
                        @foreach($paymentSystems as $paymentSystem)
                            <x-adminlte-select name="{{ $paymentSystem->value }}" label="{{ $paymentSystem->name }} Payouts" error-key="{{ $paymentSystem->value }}">
                                <option value="1" {{ $paymentSystem->payouts_enabled ? 'selected' : '' }}>Enabled</option>
                                <option value="0" {{ !$paymentSystem->payouts_enabled ? 'selected' : '' }}>Disabled</option>
                            </x-adminlte-select>

                        @endforeach
                        <x-adminlte-button type="submit" label="Update settings" theme="primary"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
