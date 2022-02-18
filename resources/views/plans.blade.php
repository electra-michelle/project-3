    <section class="testimonial-2  section-padding">
        <img src="/images/testmonial-shape.png" alt="" class="anim-img">
        <img src="/images/testmonial-shape.png" alt="" class="anim-img anim-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-intro">
                        <h2 class="section-title">Explore Our Investment Plans<span class="color">.</span></h2>
                        <p>Become a member and start your alternative investment journey.
Our services are designed with financial professionals in mind.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center mb-5">
                    <div id="limits" class="btn-group btn-group-lg" role="group">
                        @foreach($paymentSystems->pluck('currency')->unique() as $currency)
                        <button type="button" class="btn btn-primary  @if($loop->first) active @endif">{{ $currency }}</button>
                        @endforeach
                    </div>
                </div>
                @foreach($plans as $plan)
                <div class="col-lg-4">
                    <div class="pricingTable">
                        <div class="pricingTable-header">
                            <h3 class="heading">{{ $plan->name }}</h3>
                            <div class="price-value"> {{ round($plan->periods_avg_interest, 2) }}% <span class="month">{{ $plan->period_type }}</span></div>
                            <div><strong class="month">for {{ $plan->periods_max_period_end }} days</strong></div>
                        </div>
                        <div class="pricing-content">
                            <ul>
                                @foreach($plan->limits->keyBy('currency') as $limit)
                                    <li class="limits limit-{{ $limit->currency }} @if($loop->first) active @endif"><b>Minimum:</b> {{ round($limit->min_amount, 8) }} {{ $limit->currency }}</li>
                                    <li class="limits limit-{{ $limit->currency }} @if($loop->first) active @endif"><b>Maximum:</b> {{ round($limit->max_amount, 8) }} {{ $limit->currency }}</li>
                                @endforeach
                                <li><b>Affiliate commission:</b> {{ round($plan->affiliate_commission, 2) }}% </li>
                                <li><b>Total return:</b> {{ round($plan->periods_avg_interest*$plan->periods_max_period_end) }}% </li>
                                <li><b>Principals included</b></li>
                            </ul>
                        </div>
                        <div class="pricingTable-signup">
                            <a class="custom-btn" href="{{ route('account.deposit') }}">Make investment</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
