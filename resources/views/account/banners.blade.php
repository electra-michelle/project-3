@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Marketing tools',
        'description' => 'Access our pre-made marketing tools'
    ])
    @include('account.__partials.nav')
    <section class="growth-section section-padding">
        <img src="/images/testmonial-shape.png" alt="" class="anim-img">
        <img src="/images/testmonial-shape.png" alt="" class="anim-img anim-2">
        <div class="container">
            <div class="banner text-center" style="color: #00415D">
                <strong>Affiliate link:</strong> {{ route('referral', auth()->user()->ref_url) }}
            </div>
            <div class="banner">
                <h3 class="section-title">120x120px banner</h3>
                <hr/>
                <img src="/120.gif" alt="{{ config('app.name') }}"/>
                <hr/>
                <h6>HTML code:</h6>
                <pre><code
                        class="language-html">{{ '<a href="' . route('referral', auth()->user()->ref_url) . '"><img src="' . route('home') . '/120.gif" alt="' . config('app.name') . '" /></a>' }}</code></pre>
            </div>
            <div class="banner">
                <h3 class="section-title">125x125px banner</h3>
                <hr/>
                <img src="/125.gif" alt="{{ config('app.name') }}"/>
                <hr/>
                <h6>HTML code:</h6>
                <pre><code
                        class="language-html">{{ '<a href="' . route('referral', auth()->user()->ref_url) . '"><img src="' . route('home') . '/125.gif" alt="' . config('app.name') . '" /></a>' }}</code></pre>
            </div>
            <div class="banner">
                <h3 class="section-title">468x60px banner</h3>
                <hr/>
                <img src="/468.gif" alt="{{ config('app.name') }}"/>
                <hr/>
                <h6>HTML code:</h6>
                <pre><code
                        class="language-html">{{ '<a href="' . route('referral', auth()->user()->ref_url) . '"><img src="' . route('home') . '/486.gif" alt="' . config('app.name') . '" /></a>' }}</code></pre>
            </div>
            <div class="banner">
                <h3 class="section-title">728x90px banner</h3>
                <hr/>
                <img src="/728.gif" alt="{{ config('app.name') }}"/>
                <hr/>
                <h6>HTML code:</h6>
                <pre><code
                        class="language-html">{{ '<a href="' . route('referral', auth()->user()->ref_url) . '"><img src="' . route('home') . '/728.gif" alt="' . config('app.name') . '" /></a>' }}</code></pre>
            </div>
        </div>
    </section>
@endsection

@section('js')

    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.4.0/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>
@endsection
