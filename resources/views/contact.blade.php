@extends('layouts.app')

@section('content')
@include('layouts.breadcrumb', [
    'title' => 'Contact us',
    'description' => 'If you have any questions, just fill the contact form and we will answer you shortly.'
])

<!-- Contact Section Start -->
<section class="contact-section spaceBig">
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="contact-wrap">
                    <div class="contact-form">
                        @if(session()->has('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @error(recaptchaFieldName())
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <form method="post" action="{{ route('contact') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name*</label>
                                        <input type="text" id="name" name="name" @error('name') class="is-invalid" @enderror value="{{ old('name') }}">
                                        @error('name')
                                        <div class="invalid-feedback">
                                           {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email*</label>
                                        <input type="email" id="email" name="email" @error('email') class="is-invalid" @enderror value="{{ old('email') }}">
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject*</label>
                                <input type="text" id="subject" name="subject" @error('subject') class="is-invalid" @enderror  value="{{ old('subject') }}">
                                @error('subject')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="message">Message*</label>
                                    <textarea  id="message" name="message"  @error('message') class="is-invalid" @enderror cols="30" rows="9"
                                               >{{ old('message') }}</textarea>
                                @error('subject')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            {!! htmlFormSnippet() !!}
                            <div class="form-group">
                                <button type="submit" class="custom-btn">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->
@endsection
@section('js')
    {!! htmlScriptTagJsApi() !!}
@endsection
