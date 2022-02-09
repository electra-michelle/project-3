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
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.4.0/styles/agate.min.css">

    <!-- Style css -->
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/all.min.css">

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
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-social">
                        <ul>
                            <li><a href="#"><i class="fab fa-fw fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-fw fa-telegram-plane"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="primary-navigation sticky-header">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light">
                <!-- Logo Here -->
                <a class="navbar-brand pl-5" href="{{ route('home') }}"><img src="/images/alt-logo.png" alt="Logo"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav {{Route::currentRouteName() == 'home' ? 'mx-auto' : 'ml-auto'  }}">
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
                        @guest
                            <li class="nav-item btn-link">
                                <a class="nav-link custom-btn" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item btn-link">
                                <a class="nav-link custom-btn" href="{{ route('register') }}">Register</a>
                            </li>
                        @else
                            <li class="nav-item btn-link">
                                <a class="nav-link custom-btn" href="{{ route('account.dashboard') }}">Account</a>
                            </li>
                            <li class="nav-item btn-link">
                                <a class="nav-link custom-btn" href="{{ route('logout') }}">Logout</a>
                            </li>
                        @endguest
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
                            <a href="{{ route('home') }}"><img src="/images/f-logo.png" alt="Logo"></a>
                        </div>
                        <p>Lorem Ipsum available, but the majority suffered alteration in some form, by humour, or
                            randomised words.</p>
                    </div>

                </div>
                <!-- Footer Widget End -->
                <div class="col-lg-4 col-sm-6">
                    <div class="footer-widget">
                        <h3 class="widget-title">Quick Links <span>.</span></h3>
                        <ul>
                            <li><a href="contact.html">Make Appointment</a></li>
                            <li><a href="service-details.html">Customer Services</a></li>
                            <li><a href="about.html">About Company</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Footer Widget End -->
                <div class="col-lg-4 col-sm-6">
                    <div class="footer-widget contact-widget">
                        <h3 class="widget-title">Follow us <span>.</span></h3>
                        <div class="footer-contact">
                            <p><a href=""><i class="fab fa-fw fa-facebook-f"></i> Facebook</a></p>
                            <p><a href=""><i class="fab fa-fw fa-telegram-plane"></i> Telegram</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Copyright © {{ now()->format('Y') }}. All Rights Reserved by <a href="{{ route('home') }}">{{ config('app.name') }}</a></p>
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
