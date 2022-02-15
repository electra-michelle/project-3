@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
    'title' => 'Register',
    'description' => 'Fill the form to create account'])


    <!-- My Account Section Start -->
    <section class="my-account spaceBig">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-sm-10 offset-sm-1">
                    <div class="acount-wrap login-wrap">
                        <form action="{{ route('register') }}" method="post">
                            @error(recaptchaFieldName())
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @csrf
                            <div class="form-group">
                                <label for="name">Name*</label>
                                <input type="text" name="name" id="name"  @error('name') class="is-invalid" @enderror value="{{ old('name') }}">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">E-Mail*</label>
                                <input type="email" name="email" id="email"  @error('email') class="is-invalid" @enderror value="{{ old('email') }}">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="username">Username*</label>
                                <input type="text" name="username" id="username"  @error('username') class="is-invalid" @enderror value="{{ old('username') }}">
                                @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password *</label>
                                <input type="password" name="password" id="password"  @error('password') class="is-invalid" @enderror>
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password *</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"  @error('password_confirmation') class="is-invalid" @enderror>
                                @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <hr />
                            @foreach($paymentSystems as $paymentSystem)
                            <div class="form-group">
                                <label for="{{ $paymentSystem->value }}">{{ $paymentSystem->name }} Wallet</label>
                                <input type="text" name="{{ $paymentSystem->value }}" id="{{ $paymentSystem->value }}"  @error($paymentSystem->value) class="is-invalid" @enderror value="{{ old($paymentSystem->value) }}">
                                @error($paymentSystem->value)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            @endforeach
                            {!! htmlFormSnippet() !!}
                            <button class="custom-btn full">Create Account</button>
                            <div class="text-right">
                                Already have an account? <a href="{{ route('login') }}">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- My Account Section End -->

@endsection


@section('js')
    {!! htmlScriptTagJsApi() !!}
@endsection
