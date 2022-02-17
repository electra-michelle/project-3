@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Affiliate',
        'description' => 'Best Affiliate Network for Advertisers'
    ])


    <!-- Benifit Section Start -->
    <section class="benifit section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-12 order-lg-2">
                    <div class="benifit-img">
                        <img src="/images/benifit-th.jpg" alt="">
                        <div class="img-meta">
                            <label><span class="counter">26</span>+</label>
                            <p>Years Of Experience</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="benifit2-txt">
                        <h2 class="section-title">Best Affiliate Network for Advertisers<span class="color">.</span>
                        </h2>
                        <p>Every aspect of our affiliate program has been flexibly designed to meet the needs of
                            innovative online marketers in a rapidly changing financial referral landscape. Become a
                            partner today and start growing your business with a forex broker you can trust.
                        </p>
                        <div class="benifit-options">
                            <div class="single-benifit">
                                <span><i class="flaticon-planning"></i></span>
                                <div class="sb-txt">
                                    <h3>Resources</h3>
                                    <p>A wide range of marketing tools including banners, landing pages, and educational
                                        material such as trading guides, reviews, and videos.</p>
                                </div>
                            </div>
                            <div class="single-benifit">
                                <span><i class="flaticon-project"></i></span>
                                <div class="sb-txt">
                                    <h3>Payments</h3>
                                    <p>Get up to 5% commission per client with unlimited earning potential. Flexible
                                        payment structures to suit your business. Fast and reliable payments on time,
                                        every time.</p>
                                </div>
                            </div>
                            <div class="single-benifit">
                                <span><i class="flaticon-project"></i></span>
                                <div class="sb-txt">
                                    <h3>Support</h3>
                                    <p>Enjoy a great self-converting product with conversion optimised content, and
                                        banners. Our highly effective sales teams contact every lead.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Benifit Section End -->
    <!-- Growth Section End -->
    <section class="team">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-lg-6 col-md-6">
                    <div class="offer-intro">
                        <h2 class="section-title">We Are Pleased to Meet You<span class="color">.</span></h2>
                        <p>Lorem Ipsum available the majority have suffered alteration
                            in some form, by injected humour, or randomised.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="service-btn text-end">
                        <a href="team.html" class="custom-btn">Join Our Team <i class="flaticon-next-1"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Growth Section Start -->
    <section class="growth-section section-padding">
        <img src="/images/testmonial-shape.png" alt="" class="anim-img">
        <img src="/images/testmonial-shape.png" alt="" class="anim-img anim-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-intro">
                        <h2 class="section-title">Get Exceptional
                            Service For Growth<span class="color">.</span></h2>
                        <p>Lorem Ipsum available the majority have suffered alteration
                            in some form, by injected humour, or randomised.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="growth-card lg-card" style="background-image: url('images/gr1.jpg');">
                        <div class="growth-img">
                        </div>
                        <div class="growth-txt">
                            <h3><a href="service-details.html">Financial Consulting</a></h3>
                            <p>Lorem Ipsum available, but the majority
                                have suffered alteration in some.</p>
                            <a href="service-details.html"><i class="flaticon-next-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="growth-card" style="background-image: url('images/gr3.jpg');">
                        <div class="growth-txt">
                            <h3><a href="service-details.html">Business Consulting</a></h3>
                            <p>Lorem Ipsum available, but the majority
                                have suffered alteration in some.</p>
                            <a href="service-details.html"><i class="flaticon-next-1"></i></a>
                        </div>
                    </div>
                    <div class="growth-card" style="background-image: url('images/gr4.jpg');">
                        <div class="growth-txt">
                            <h3><a href="service-details.html">Meet our Goal</a></h3>
                            <p>Lorem Ipsum available, but the majority
                                have suffered alteration in some.</p>
                            <a href="service-details.html"><i class="flaticon-next-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
