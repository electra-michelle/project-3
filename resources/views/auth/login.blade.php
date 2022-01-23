@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Login',
        'description' => 'Sign in to access your account'])


    <!-- My Account Section Start -->
    <section class="my-account spaceBig">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1">
                    <div class="acount-wrap login-wrap">
                        <form action="{{ route('login') }}" method="post">
                            @error(recaptchaFieldName())
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @csrf
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
                            {!! htmlFormSnippet() !!}
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>
                            <button class="custom-btn full">Login</button>
                            <div class="text-right">
                                <a href="{{ route('password.request') }}">Forgot your password?</a><br>
                                <a href="{{ route('register') }}">Don't have an account? </a>
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
