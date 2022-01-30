@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Investments',
        'description' => 'You have questions? We have answers!'
    ])

    <section class="testimonial-2  section-padding">
        <img src="/images/testmonial-shape.png" alt="" class="anim-img">
        <img src="/images/testmonial-shape.png" alt="" class="anim-img anim-2">
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
                <div class="col-md-4">
                    <div class="pricingTable">
                        <div class="pricingTable-header">
                            <h3 class="heading">Basic</h3>
                            <div class="price-value"> 12% <span class="month">daily</span></div>
                            <div><strong class="month">for 10 days</strong></div>
                        </div>
                        <div class="pricing-content">
                            <ul>
                                <li><b>50GB</b> Disk Space</li>
                                <li><b>50</b> Email Accounts</li>
                                <li><b>50GB</b> Monthly Bandwidth</li>
                                <li><b>10</b> subdomains</li>
                                <li><b>15</b> Domains</li>
                            </ul>
                        </div>
                        <div class="pricingTable-signup">
                            <a class="custom-btn" href="#">sign up</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="pricingTable">
                        <div class="pricingTable-header">
                            <h3 class="heading">Standard</h3>
                            <div class="price-value"> 8.5% <span class="month">daily</span></div>
                            <div><strong class="month">for 10 days</strong></div>
                        </div>
                        <div class="pricing-content">
                            <ul>
                                <li><b>60GB</b> Disk Space</li>
                                <li><b>60</b> Email Accounts</li>
                                <li><b>60GB</b> Monthly Bandwidth</li>
                                <li><b>15</b> subdomains</li>
                                <li><b>20</b> Domains</li>
                            </ul>
                        </div>
                        <div class="pricingTable-signup">
                            <a class="custom-btn" href="#">sign up</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pricingTable">
                        <div class="pricingTable-header">
                            <h3 class="heading">Professional</h3>
                            <div class="price-value"> 5.5% <span class="month">daily</span></div>
                            <div><strong class="month">for 10 days</strong></div>
                        </div>
                        <div class="pricing-content">
                            <ul>
                                <li><b>70GB</b> Disk Space</li>
                                <li><b>70</b> Email Accounts</li>
                                <li><b>70GB</b> Monthly Bandwidth</li>
                                <li><b>20</b> subdomains</li>
                                <li><b>25</b> Domains</li>
                            </ul>
                        </div>
                        <div class="pricingTable-signup">
                            <a class="custom-btn" href="#">sign up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="calculator" class="testimonial section-padding">
        <img src="images/dot-graphic.png" alt="" class="anim-img">
        <img src="images/dot-graphic.png" alt="" class="anim-img anim-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-intro">
                        <h2 class="section-title">Calculate your income<span class="color">.</span></h2>
                        <p>Lorem Ipsum available the majority have suffered alteration
                            in some form, by injected humour, or randomised.</p>
                    </div>
                </div>
            </div>
            <form action="">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="method">Investment Method</label>
                        <select id="method" name="method" class="form-control">
                            <option>ePayCore</option>
                            <option>Bitcoin</option>
                            <option>Bitcoin Cash</option>
                            <option>Litecoin</option>
                            <option>Dogecoin</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <div class="input-group">
                            <input id="amount" name="amount" type="text" class="form-control">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">USD</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="method">Investment Plan</label>
                        <select id="method" name="plan" class="form-control">
                            <option>plan 1</option>
                            <option>plan 2</option>
                            <option>plan 3</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr />
            <div class="text-center pt-3">
                <button type="submit" class="custom-btn">Invest now</button>
            </div>
            </form>
        </div>
    </section>

@endsection
@section('js')
    {!! htmlScriptTagJsApi() !!}
@endsection
