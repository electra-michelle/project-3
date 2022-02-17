@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Trouble signing in?',
        'description' => 'Resetting your password is easy'])


    <!-- My Account Section Start -->
    <section class="my-account spaceBig">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1">
                    <div class="acount-wrap login-wrap">
                        <form action="{{ route('password.email') }}" method="post">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @error(recaptchaFieldName())
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @csrf
                            <div class="form-group">
                                <label for="email">E-Mail*</label>
                                <input type="text" name="email" id="email"  @error('email') class="is-invalid" @enderror value="{{ old('email') }}">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            {!! htmlFormSnippet() !!}
                            <button class="custom-btn full">Send Password Reset Link</button>
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
