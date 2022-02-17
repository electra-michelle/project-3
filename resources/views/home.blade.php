@extends('layouts.app')

@section('content')
<!-- Banner Section Start -->
<section class="banner-section video-banner">
    <img src="/images/grey-dots.png" alt="" class="anim-2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 col-xl-6 order-md-1">
                <div class="slide-img">
                    <div class="video-img">
                        <img src="/images/video-promo.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-6">
                <div class="slide-txt">
                    <h1 class="banner-title">Build Your Intelligent Future Portfolio<span>.</span></h1>
                    <p>We are an experienced team of investing professionals readily available to manage your funds. Leverage the knowledge of our team network we have created.
                    </p>
                   <a href="{{ route('investments') }}" class="custom-btn">Discover our plans</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->

<section class="service-section section-padding">
    <div class="container">
        <div class="row g-0 service-inner">
            <div class="col-lg-4 col-md-4">
                <div class="service-card">
                    <h3>100% Satisfactions</h3>
                    <p>Customer satisfaction is our #1 priority. We're introducing protection for every investment.
                    </p>
                </div>
            </div> <!-- service card end -->
            <div class="col-lg-4 col-md-4">
                <div class="service-card">
                    <h3>Expert Insights</h3>
                    <p>Invest in a portfolio
                        managed by experts to target the highest long-term returns for your risk appetite.
                    </p>
                </div>
            </div> <!-- service card end -->
            <div class="col-lg-4 col-md-4">
                <div class="service-card">
                    <h3>24/7 Intouch</h3>
                    <p>Support means customers can get help and find answers to questions
                        24/7 and in real-time.</p>
                </div>
            </div> <!-- service card end -->

        </div>
    </div>
</section>
<!-- Service Section End -->

<!-- Business Section Start -->
<section class="business-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-sm-12 order-lg-1">
                <div class="business-pormo">
                    <img src="/images/serv4.jpg" alt="">
                    <img class="sm-img" src="/images/serv5.jpg" alt="">
                    <img class="sm-img" src="/images/serv6.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="about-business">
                    <h2 class="section-title">We connect people to opportunities<span class="color">.</span></h2>
                    <p>{{ config('app.name') }} investment process has captured what we believe to be the most attractive opportunities across forex markets and through market cycles</p>
                    <ul> 
                        <li>Robust fundamental analysis to determine enterprise value</li>
                        <li>Analysis of capital structure to ensure high margin of safety</li>
                        <li>Identified catalysis to drive total return</li>
                    </ul>
                    <a href="{{ route('investments') }}" class="custom-btn mt-4">See Investment Plans</a>
                </div>

            </div>

        </div>
    </div>
</section>
<!-- Business Section End -->
@include('plans')

<!-- Talk Section Start -->
<section class="talk-section">
    <div class="talk-bg" style="background-image: url('images/talk-bg.jpg');">
		<div class="container">
                <div class="talk-txt text-center">
                    <h2 class="section-title">Ready to explore Forextion platform?</h2>
                    <p> Access third-party institutional private equity & hedge funds with low investment minimums. Build custom portfolios by using our turn-key alternative investment platform.</p>
                    <a href="{{ route('register') }}" class="custom-btn">Access Now </a>
                </div>
			</div>
    </div>
</section>
<!-- Talk Section End -->

@endsection
@section('js')
    {!! htmlScriptTagJsApi() !!}

    <script>
        $("#limits button").on('click', function() {
            $("#limits button").removeClass('active');
            $(this).addClass('active');
            var currency = $(this).text();

            $(".limits").removeClass('active');
            $(".limits.limit-" + currency).addClass('active');
        });

    </script>
@endsection
