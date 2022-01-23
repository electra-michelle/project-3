<!-- Promo Section Start -->
<section class="promo-section promo-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="promo-wrap text-center">
                    <h2>{{ $title }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">

                            @foreach($sections as $route => $name)
                                @if(end($sections) == $name)
                                    <li class="breadcrumb-item active">{{ $name }}</li>
                                @else
                                <li class="breadcrumb-item"><a href="{{ route($route) }}">{{ $name }}</a></li>
                                @endif
                            @endforeach
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Promo Section End -->
