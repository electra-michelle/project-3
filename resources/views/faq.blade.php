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
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                        How much our experience?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                     aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Lorem Ipsum available, but the majority have suffered alteration
                                        in some form, by injected humour, or randomised words which
                                        don't look even slightly believable.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading0">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse0" aria-expanded="false" aria-controls="collapse0">
                                        Title 0 <i class="bx bx-chevron-down"></i></button>
                                </h2>
                                <div id="collapse0" class="accordion-collapse collapse" aria-labelledby="heading0"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 0</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading1">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                        Title 1 <i class="bx bx-chevron-down"></i></button>
                                </h2>
                                <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 1</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                        Title 2 <i class="bx bx-chevron-down"></i></button>
                                </h2>
                                <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 2</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading3">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                        Title 3 <i class="bx bx-chevron-down"></i></button>
                                </h2>
                                <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 3</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading4">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                        Title 4 <i class="bx bx-chevron-down"></i></button>
                                </h2>
                                <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 4</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading5">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                        Title 5 <i class="bx bx-chevron-down"></i></button>
                                </h2>
                                <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 5</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading6">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                        Title 6 <i class="bx bx-chevron-down"></i></button>
                                </h2>
                                <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 6</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading7">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                        Title 7 <i class="bx bx-chevron-down"></i></button>
                                </h2>
                                <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 7</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading8">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                        Title 8 <i class="bx bx-chevron-down"></i></button>
                                </h2>
                                <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 8</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading9">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                                        Title 9 <i class="bx bx-chevron-down"></i></button>
                                </h2>
                                <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 9</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading10">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse10" aria-expanded="false"
                                            aria-controls="collapse10"> Title 10 <i class="bx bx-chevron-down"></i>
                                    </button>
                                </h2>
                                <div id="collapse10" class="accordion-collapse collapse" aria-labelledby="heading10"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 10</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading11">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse11" aria-expanded="false"
                                            aria-controls="collapse11"> Title 11 <i class="bx bx-chevron-down"></i>
                                    </button>
                                </h2>
                                <div id="collapse11" class="accordion-collapse collapse" aria-labelledby="heading11"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 11</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading12">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse12" aria-expanded="false"
                                            aria-controls="collapse12"> Title 12 <i class="bx bx-chevron-down"></i>
                                    </button>
                                </h2>
                                <div id="collapse12" class="accordion-collapse collapse" aria-labelledby="heading12"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 12</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading13">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse13" aria-expanded="false"
                                            aria-controls="collapse13"> Title 13 <i class="bx bx-chevron-down"></i>
                                    </button>
                                </h2>
                                <div id="collapse13" class="accordion-collapse collapse" aria-labelledby="heading13"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 13</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading14">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse14" aria-expanded="false"
                                            aria-controls="collapse14"> Title 14 <i class="bx bx-chevron-down"></i>
                                    </button>
                                </h2>
                                <div id="collapse14" class="accordion-collapse collapse" aria-labelledby="heading14"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 14</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading15">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse15" aria-expanded="false"
                                            aria-controls="collapse15"> Title 15 <i class="bx bx-chevron-down"></i>
                                    </button>
                                </h2>
                                <div id="collapse15" class="accordion-collapse collapse" aria-labelledby="heading15"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 15</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading16">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse16" aria-expanded="false"
                                            aria-controls="collapse16"> Title 16 <i class="bx bx-chevron-down"></i>
                                    </button>
                                </h2>
                                <div id="collapse16" class="accordion-collapse collapse" aria-labelledby="heading16"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 16</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading17">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse17" aria-expanded="false"
                                            aria-controls="collapse17"> Title 17 <i class="bx bx-chevron-down"></i>
                                    </button>
                                </h2>
                                <div id="collapse17" class="accordion-collapse collapse" aria-labelledby="heading17"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 17</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading18">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse18" aria-expanded="false"
                                            aria-controls="collapse18"> Title 18 <i class="bx bx-chevron-down"></i>
                                    </button>
                                </h2>
                                <div id="collapse18" class="accordion-collapse collapse" aria-labelledby="heading18"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 18</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading19">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse19" aria-expanded="false"
                                            aria-controls="collapse19"> Title 19 <i class="bx bx-chevron-down"></i>
                                    </button>
                                </h2>
                                <div id="collapse19" class="accordion-collapse collapse" aria-labelledby="heading19"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 19</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading20">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse20" aria-expanded="false"
                                            aria-controls="collapse20"> Title 20 <i class="bx bx-chevron-down"></i>
                                    </button>
                                </h2>
                                <div id="collapse20" class="accordion-collapse collapse" aria-labelledby="heading20"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body"> description 20</div>
                                </div>
                            </div>

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
