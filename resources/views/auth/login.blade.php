@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Login',
        'sections' => [
            'home' => 'Home',
            'login' => 'Login',
        ]])


    <!-- My Account Section Start -->
    <section class="my-account spaceBig">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1">
                    <div class="acount-wrap login-wrap">
                        <h2>Login</h2>
                        <p>Don't have an account <a href="{{ route('register') }}">Create here </a></p>
                        <form action="{{ route('login') }}" method="post">
                            <div class="form-group">
                                <label for="username">Username*</label>
                                <input type="text" name="username" id="username" value="{{ old('username') }}">
                            </div>
                            <div class="form-group">
                                <label for="password">Password *</label>
                                <input type="password" name="password" id="password">
                            </div>
                            <div class="form-group">
                                <label for="password">Security code *</label>
                                <div class="login-half">
                                    <div class="chek-form">
                                        <input type="text" required="" name="email" placeholder="Security code *">
                                    </div>
                                    <span class="security-code">
                                        <b class="text-danger">2</b>
                                        <b class="text-secondary">6</b>
                                        <b class="text-primary">2</b>
                                        <b class="text-success">7</b>
                                    </span>
                                </div>
                            </div>
                            {!! htmlFormSnippet() !!}
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>
                            <button class="custom-btn full">Login</button>
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
