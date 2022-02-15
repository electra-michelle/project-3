@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Settings',
        'description' => '12321321'
    ])
    @include('account.__partials.nav')

        <section class="growth-section checkout-section section-padding">
            <img src="/images/testmonial-shape.png" alt="" class="anim-img">
            <img src="/images/testmonial-shape.png" alt="" class="anim-img anim-2">
        <div class="container">
            <form action="{{ route('account.settings') }}" method="POST" class="form checkout-form">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Billing Form -->
                        <div class="checkout-billingform">
                            @if(session()->has('settings_updated'))
                                <div class="alert alert-success">{{ session('settings_updated') }}</div>
                            @endif
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger">{{ $error }}</div>
                            @endforeach
                            <h3 class="section-title">Profile information</h3>
                            <div class="form-inner">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}">
                                </div>
                                <div class="form-group">
                                    <label for="name">Username</label>
                                    <input type="text" id="username" value="{{ $user->username }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="email">E-Mail</label>
                                    <input type="text" id="email" value="{{ $user->email }}" readonly>
                                </div>
                            </div>
                            <hr/>
                            <h3 class="section-title">Update password</h3>
                            <div class="form-inner">
                                <div class="form-group">
                                    <label for="old_password">Old password</label>
                                    <input type="password" name="old_password" id="old_password">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="new_password">New Password</label>
                                            <input type="password" name="new_password" id="new_password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="new_password_confirmation">New Password Confirmation</label>
                                            <input type="password" name="new_password_confirmation"
                                                   id="new_password_confirmation">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <h3 class="section-title">Wallets</h3>
                            @foreach($paymentSystems as $paymentSystem)
                                <div class="form-inner">
                                    <div class="form-group">
                                        <label for="email">{{ $paymentSystem->name }} Wallet</label>
                                        <input type="text" id="{{ $paymentSystem->value }}"
                                               name="{{ $paymentSystem->value }}"
                                               value="{{ old($paymentSystem->value, $wallets[$paymentSystem->id] ?? null) }}">
                                    </div>
                                </div>
                        @endforeach
                        <!--// Different Address Form -->
                            <div class="mt-3">
                                <button class="custom-btn">Save settings</button>
                            </div>
                        </div>
                        <!--// Billing Form -->
                    </div>
                </div>
            </form>
        </div>
        <!--// Checkout Area -->
    </section>
@endsection

