<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" href="/images/favicon.png">
    <link rel="shortcut icon" href="/images/favicon.ico">

    <!-- Css Library -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/animate.css">
    <link rel="stylesheet" href="/font/flaticon.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/css/venobox.min.css">
    <link rel="stylesheet" href="/css/jquery-ui.min.css">

    <!-- Style css -->
    <link rel="stylesheet" href="/css/style.css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<!-- Preloader start-->
<div id="preloader">
    <div class="preloader">
        <span></span>
        <span></span>
    </div>
</div>
<!-- Preloader end  -->

<!-- Index Header Start -->
<header class="header {{Route::currentRouteName() == 'home' ? 'index-header' : 'header-bg'  }}">
    <div class="header-top">
        <div class="container header-line">
            <div class="top-info">
                <ul>
                    <li><i class="flaticon-pin"></i>234 King Street, Australia</li>
                    <li><i class="flaticon-phone-call"></i><a href="tel://+1-800-915-6270">+1-800-915-6270</a></li>
                    <li><i class="flaticon-email"></i><a href="mailto://admin@consulpro.com">admin@consulpro.com</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="primary-navigation sticky-header">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light">
                <!-- Logo Here -->
                <a class="navbar-brand pl-5" href="index.html"><img src="images/alt-logo.png" alt="Logo"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('investments') }}">Investments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('affiliate') }}">Affiliate</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('faq') }}">FAQ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    </ul>

                </div>
            </nav>
        </div>
    </div>
</header>
<!-- Header End -->

@yield('content')

<!-- Footer Section Start -->
<footer class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="footer-widget about-footer">
                        <div class="f-logo mb-4">
                            <a href="index.html"><img src="images/f-logo.png" alt="Logo"></a>
                        </div>
                        <p>Lorem Ipsum available, but the majority suffered alteration in some form, by humour, or
                            randomised words.</p>
                        <div class="footer-social mt-5">
                            <span><a href="#"><i class="flaticon-facebook"></i></a></span>
                            <span><a href="#"><i class="flaticon-linkedin"></i></a></span>
                            <span><a href="#"><i class="flaticon-twitter"></i></a></span>
                            <span><a href="#"><i class="flaticon-instagram"></i></a></span>
                            <span><a href="#"><i class="flaticon-pinterest"></i></a></span>

                        </div>
                    </div>

                </div>
                <!-- Footer Widget End -->
                <div class="col-lg-2 col-sm-6">
                    <div class="footer-widget">
                        <h3 class="widget-title">Quick Links <span>.</span></h3>
                        <ul>
                            <li><a href="contact.html">Make Appointment</a></li>
                            <li><a href="service-details.html">Customer Services</a></li>
                            <li><a href="about.html">About Company</a></li>
                            <li><a href="portfolio-2.html">Our Case Studies</a></li>
                            <li><a href="contact.html">Free Consultation</a></li>
                            <li><a href="team.html">Meet Our Experts</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Footer Widget End -->
                <div class="col-lg-3 col-sm-6">
                    <div class="footer-widget contact-widget">
                        <h3 class="widget-title">Contact Info <span>.</span></h3>
                        <div class="footer-contact">
                            <p><i class="flaticon-pin"></i> 1234 King Street, Australia</p>
                            <p><i class="flaticon-phone-call"></i> <a
                                    href="tel://+1-800-915-6270">+1-800-915-6270</a></p>
                            <p><i class="flaticon-email"></i><a
                                    href="mailto://consulpro@mail.com">consulpro@mail.com</a></p>
                        </div>
                    </div>
                </div>
                <!-- Footer Widget End -->
                <div class="col-lg-3 col-sm-6">
                    <div class="footer-widget">
                        <h3 class="widget-title">Recent Posts <span>.</span></h3>
                        <div class="latest-posts clearfix">
                            <div class="ls-single">
                                <a href="#"><img src="images/ls1.jpg" alt=""></a>
                            </div>
                            <div class="ls-single">
                                <a href="#"><img src="images/ls2.jpg" alt=""></a>
                            </div>
                            <div class="ls-single">
                                <a href="#"><img src="images/ls3.jpg" alt=""></a>
                            </div>
                            <div class="ls-single">
                                <a href="#"><img src="images/ls4.jpg" alt=""></a>
                            </div>
                            <div class="ls-single">
                                <a href="#"><img src="images/ls5.jpg" alt=""></a>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Footer Widget End -->
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-7">
                    <p>© 2021 All Rights Reserved by <a href="https://themeforest.net/user/theme-village"
                                                        rel="noopener" target="_blank">theme-vilage</a></p>
                </div>
                <div class="col-lg-6 col-sm-5">
                    <nav class="footer-nav">
                        <ul>
                            <li><a href="index.html">Home</a></li>
                            <li><a href="about.html">About</a></li>
                            <li><a href="services.html">Services</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

<!--
Javascript
========================================================-->

<script src="/js/jquery-3.6.0.min.js"></script>
<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/jquery.scrollUp.min.js"></script>
<script src="/js/owl.carousel.min.js"></script>
<script src="/js/wow.min.js"></script>
<script src="/js/waypoints.js"></script>
<script src="/js/jquery.counterup.min.js"></script>
<script src="/js/venobox.min.js"></script>
<script src="/js/isotope.pkgd.min.js"></script>
<script src="/js/jquery-ui.min.js"></script>
<script src="/js/jquery.ajaxchimp.min.js"></script>
<!-- Custom Js -->
<script src="/js/custom.js"></script>

@yield('js')
</body>

</html>
