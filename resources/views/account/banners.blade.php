@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Marketing tools',
        'description' => '12321321'
    ])
    @include('account.__partials.nav')
    <section class="growth-section section-padding">
        <img src="/images/testmonial-shape.png" alt="" class="anim-img">
        <img src="/images/testmonial-shape.png" alt="" class="anim-img anim-2">
        <div class="container">
            <div class="banner">
                <h3 class="section-title">120x120px banner</h3>
                <hr />
                <img src="https://via.placeholder.com/120x120.gif" alt="{{ config('app.name') }}" /><hr />
                <h6>HTML code:</h6>
                <pre><code class="language-html">{{ '<a href="' . route('home', ['ref' => auth()->user()->ref_url]) . '"><img src="https://via.placeholder.com/120x120.gif" alt="' . config('app.name') . '" /></a>' }}</code></pre>
            </div>
            <div class="banner">
                <h3 class="section-title">125x125px banner</h3>
                <hr />
                <img src="https://via.placeholder.com/125x125.gif" alt="{{ config('app.name') }}" /><hr />
                <h6>HTML code:</h6>
                <pre><code class="language-html">{{ '<a href="' . route('home', ['ref' => auth()->user()->ref_url]) . '"><img src="https://via.placeholder.com/125x125.gif" alt="' . config('app.name') . '" /></a>' }}</code></pre>
            </div>
            <div class="banner">
                <h3 class="section-title">468x60px banner</h3>
                <hr />
                <img src="https://via.placeholder.com/468x60.gif" alt="{{ config('app.name') }}" /><hr />
                <h6>HTML code:</h6>
                <pre><code class="language-html">{{ '<a href="' . route('home', ['ref' => auth()->user()->ref_url]) . '"><img src="https://via.placeholder.com/468x60.gif" alt="' . config('app.name') . '" /></a>' }}</code></pre>
            </div>
            <div class="banner">
                <h3 class="section-title">728x90px banner</h3>
                <hr />
                <img src="https://via.placeholder.com/728x90.gif" alt="{{ config('app.name') }}" /><hr />
                <h6>HTML code:</h6>
                <pre><code class="language-html">{{ '<a href="' . route('home', ['ref' => auth()->user()->ref_url]) . '"><img src="https://via.placeholder.com/727x90.gif" alt="' . config('app.name') . '" /></a>' }}</code></pre>
            </div>
        </div>
    </section>
@endsection

@section('js')

    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.4.0/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>
@endsection
