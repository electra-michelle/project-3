@extends('layouts.app')

@section('content')
<!-- Banner Section Start -->
<section class="banner-section video-banner">
    <img src="images/grey-dots.png" alt="" class="anim-2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 col-xl-6 order-md-1">
                <div class="slide-img">
                    <div class="video-img">
                        <img src="images/video-promo.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-6">
                <div class="slide-txt">
                    <h1 class="banner-title">Grow Your
                        Financial Wealth<span>.</span></h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                        do eiusmod tempor incididunt ut labore et dolore magna
                        aliqua. Ut enim ad minim veniam.</p>
                    <form action="#" class="mailchimp-sform">
                        <span class="input-icon"><i class="flaticon-email"></i></span>
                        <input type="email" name="subscribe" id="subscriber-email" placeholder="Enter your Email"
                               class="form-control">
                        <button type="submit" id="subscribe-button" class="custom-btn">Subscribe</button>
                        <span class="subscription-success text-success"> </span>
                        <span class="subscription-error text-danger"> </span>
                        <label class="subscription-label text-white" for="subscriber-email"></label>
                    </form>
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
                    <p>Lorem Ipsum available, but the
                        majority have suffered alteration
                        some form, by injected.</p>
                </div>
            </div> <!-- service card end -->
            <div class="col-lg-4 col-md-4">
                <div class="service-card">
                    <h3>24/7 Solutions</h3>
                    <p>Lorem Ipsum available, but the
                        majority have suffered alteration
                        some form, by injected.</p>
                </div>
            </div> <!-- service card end -->
            <div class="col-lg-4 col-md-4">
                <div class="service-card">
                    <h3>Free Consulting</h3>
                    <p>Lorem Ipsum available, but the
                        majority have suffered alteration
                        some form, by injected.</p>
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
                    <img src="images/serv4.jpg" alt="">
                    <img class="sm-img" src="images/serv5.jpg" alt="">
                    <img class="sm-img" src="images/serv6.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="about-business">
                    <h2 class="section-title">Get Right Solution For Your Business<span class="color">.</span></h2>
                    <p>Lorem Ipsum available the majority have suffered alteration in some form, by injected humour,
                        or randomised</p>
                    <ul>
                        <li>Words which don't look even slightly believable!</li>
                        <li>To use a passage of Lorem Ipsum, you be sure</li>
                        <li>Anything embarrassing hidden in middle of text.</li>
                    </ul>
                    <a href="about.html" class="custom-btn mt-4">Read More</a>
                </div>

            </div>

        </div>
    </div>
</section>
<!-- Business Section End -->

<!-- Growth Section Start -->
<section class="growth-section section-padding">
    <img src="images/testmonial-shape.png" alt="" class="anim-img">
    <img src="images/testmonial-shape.png" alt="" class="anim-img anim-2">
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
<!-- Growth Section End -->

<!-- Benifit Section Start -->
<section class="benifit section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-12 order-lg-2">
                <div class="benifit-img">
                    <img src="images/benifit-th.jpg" alt="">
                    <div class="img-meta">
                        <label><span class="counter">26</span>+</label>
                        <p>Years Of Experience</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="benifit2-txt">
                    <h2 class="section-title">Countless Benefits & Easy
                        Processing<span class="color">.</span></h2>
                    <p>Lorem Ipsum available, but the majority have suffered alteration in
                        some form, by injected humour, or randomised words which don't
                        look even slightly believable.
                    </p>
                    <div class="benifit-options">
                        <div class="single-benifit">
                            <span><i class="flaticon-planning"></i></span>
                            <div class="sb-txt">
                                <h3>Consulting Planning</h3>
                                <p>Lorem Ipsum available, but the majority have suffered
                                    form, by injected humour, or randomised words.</p>
                            </div>
                        </div>
                        <div class="single-benifit">
                            <span><i class="flaticon-project"></i></span>
                            <div class="sb-txt">
                                <h3>Briefing Projects</h3>
                                <p>Lorem Ipsum available, but the majority have suffered
                                    form, by injected humour, or randomised words.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- Benifit Section End -->

<!-- Testimonial Section Start -->
<section class="testimonial-2">
    <img src="images/testmonial-shape.png" alt="" class="anim-img">
    <img src="images/testmonial-shape.png" alt="" class="anim-img anim-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-intro">
                    <h2 class="section-title">What Our Loving
                        Clients Saying<span class="color">.</span></h2>
                    <p>Lorem Ipsum available the majority have suffered alteration
                        in some form, by injected humour, or randomised.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="quote-slider2 owl-carousel">
                    <div class="quote">
                        <div class="quote-head">
                            <div class="quote-thumb">
                                <img src="images/ts1.jpg" alt="">
                            </div>
                            <div class="quote-info">
                                <h3>Tariqul Islam</h3>
                                <span>New Zealand</span>
                                <div class="ratings">
                                    <i class="flaticon-star"></i>
                                    <i class="flaticon-star"></i>
                                    <i class="flaticon-star"></i>
                                    <i class="flaticon-star"></i>
                                    <i class="flaticon-star"></i>
                                </div>
                            </div>
                        </div>
                        <p>Lorem Ipsum available, but the majority have
                            suffered alteration in some form, by injected
                            humour, or randomised words which don't
                            look even slightly believable</p>
                    </div> <!-- Quote End -->
                    <div class="quote">
                        <div class="quote-head">
                            <div class="quote-thumb">
                                <img src="images/ts1.jpg" alt="">
                            </div>
                            <div class="quote-info">
                                <h3>David Malan</h3>
                                <span>Australia</span>
                                <div class="ratings">
                                    <i class="flaticon-star"></i>
                                    <i class="flaticon-star"></i>
                                    <i class="flaticon-star"></i>
                                    <i class="flaticon-star"></i>
                                    <i class="flaticon-star-1"></i>
                                </div>
                            </div>
                        </div>
                        <p>Lorem Ipsum available, but the majority have
                            suffered alteration in some form, by injected
                            humour, or randomised words which don't
                            look even slightly believable</p>
                    </div> <!-- Quote End -->
                    <div class="quote">
                        <div class="quote-head">
                            <div class="quote-thumb">
                                <img src="images/ts1.jpg" alt="">
                            </div>
                            <div class="quote-info">
                                <h3>David Malan</h3>
                                <span>Australia</span>
                                <div class="ratings">
                                    <i class="flaticon-star"></i>
                                    <i class="flaticon-star"></i>
                                    <i class="flaticon-star"></i>
                                    <i class="flaticon-star"></i>
                                    <i class="flaticon-star-1"></i>
                                </div>
                            </div>
                        </div>
                        <p>Lorem Ipsum available, but the majority have
                            suffered alteration in some form, by injected
                            humour, or randomised words which don't
                            look even slightly believable</p>
                    </div> <!-- Quote End -->
                </div>

            </div>
        </div>
    </div>
</section>
<!-- Testimonial Section End -->

<!-- Talk Section Start -->
<section class="talk-section">
    <div class="talk-bg" style="background-image: url('images/talk-bg.jpg');">

        <div class="video-block">
            <div class="waves wave-1"></div>
            <div class="waves wave-2"></div>
            <div class="waves wave-3"></div>
            <a href="https://www.youtube.com/watch?v=PhY7uAMKYg4" class="video venobox" data-autoplay="true"
               data-vbtype="video"><i class="flaticon-play"></i></a>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="talk-txt text-center">
                    <h2 class="section-title">Consulting from Experienced Consultant.</h2>
                    <p> Lorem Ipsum available, but the majority have suffered alteration in some form, by injected
                        humour, or randomised words which don't look even slightly believable</p>
                    <a href="contact.html" class="custom-btn">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Talk Section End -->

<!-- Blog Section Start -->
<section class="blog blog-2 section-padding">
    <img src="images/testmonial-shape.png" alt="" class="anim-img">
    <img src="images/testmonial-shape.png" alt="" class="anim-img anim-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-intro">
                    <h2 class="section-title">World Consulting News & Updates<span class="color">.</span></h2>
                    <p>Lorem Ipsum available the majority have suffered alteration
                        in some form, by injected humour, or randomised.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-sm-12">
                <article class="single-entry featured-entry">
                    <div class="entry-thumb">
                        <a href="single-post.html"><img src="images/fbl1.jpg" alt=""></a>

                    </div>
                    <div class="date-meta">
                        <span>15</span>Jan
                    </div>
                    <div class="entry-txt">

                        <div class="cat-meta mb-3">
                            <span><a href="#">Consulting</a></span>
                        </div>
                        <h3><a href="single-post.html">What new technology does
                                is create new opportunities</a></h3>
                        <p>Lorem Ipsum available, but the majority have suffered alteration in some form by
                            injected
                            humour randomised.</p>
                    </div>
                </article>
            </div>
            <div class="col-lg-7 col-sm-12">
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <article class="single-entry">
                            <div class="entry-thumb">
                                <a href="single-post.html"><img src="images/bl1.jpg" alt=""></a>
                                <div class="date-meta">
                                    <span>15</span>Jan
                                </div>
                            </div>
                            <div class="entry-txt">
                                <div class="cat-meta mb-3">
                                    <span><a href="#">Consulting</a></span>
                                </div>
                                <h3><a href="single-post.html">The Human Rights and
                                        Democracy Programme</a></h3>
                                <p>Lorem Ipsum available, but have suffered alteration in some form
                                    by injected
                                    humour randomised.</p>
                            </div>
                        </article>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <article class="single-entry">
                            <div class="entry-thumb">
                                <a href="single-post.html"><img src="images/bl1.jpg" alt=""></a>
                                <div class="date-meta">
                                    <span>15</span>Jan
                                </div>
                            </div>
                            <div class="entry-txt">
                                <div class="cat-meta mb-3">
                                    <span><a href="#">Consulting</a></span>
                                </div>
                                <h3><a href="single-post.html">What new technology does
                                        is create new opportunities</a></h3>
                                <p>Lorem Ipsum available, but have suffered alteration in some form
                                    by injected
                                    humour randomised.</p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->
@endsection
