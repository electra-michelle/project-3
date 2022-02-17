@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Reset Password',
        'description' => 'Enter your new password below.'])

    <!-- My Account Section Start -->
    <section class="my-account spaceBig">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1">
                    <div class="acount-wrap login-wrap">
                        <form action="{{ route('password.update') }}" method="post">
                            <input type="hidden" name="token" value="{{ $token }}">
                            @error(recaptchaFieldName())
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @csrf
                            <div class="form-group">
                                <label for="email">E-Mail*</label>
                                <input type="text" name="email" id="email"  @error('email') class="is-invalid" @enderror value="{{ $email ?? old('email') }}">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">New Password *</label>
                                <input type="password" name="password" id="password"  @error('password') class="is-invalid" @enderror>
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm New Password *</label>
                                <input type="password" name="password_confirmation" id="password_confirmation">
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            {!! htmlFormSnippet() !!}
                            <button class="custom-btn full">Reset Password</button>
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
