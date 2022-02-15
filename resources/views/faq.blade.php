@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Frequently Asked Questions',
        'description' => 'You have questions? We have answers!'
    ])
    <!--Faq Section Start -->
    <section class="faq faq-index spaceBig">
        <div class="container">
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="faq-inner">
                        <div class="accordion" id="accordionFaq">
                            @foreach(trans('faq') as $key => $value)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-{{ $key }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-{{ $key }}" aria-expanded="false" aria-controls="collapse-{{ $key }}">
                                        {{ $value['question'] }} <i class="bx bx-chevron-down"></i></button>
                                </h2>
                                <div id="collapse-{{ $key }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $key }}"
                                     data-bs-parent="#accordionFaq">
                                    <div class="accordion-body"> {!! trans('faq.' . $key . '.answer', [
                                        'paymentSystems' => implode(', ', $paymentSystems->pluck('name')->toArray()),
                                        'minDepositLimits' => implode(', ', $minDepositLimits),
                                        'maxDepositLimits' => implode(', ', $maxDepositLimits),
                                        'withdrawMinimums' => implode(', ', $withdrawMinimums)
                                    ]) !!}</div>
                                </div>
                            </div>
                            @endforeach

                        </div><!-- Accordion End -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Faq Section End -->

    <!-- Contact Section End -->
@endsection
@section('js')
    {!! htmlScriptTagJsApi() !!}
@endsection
