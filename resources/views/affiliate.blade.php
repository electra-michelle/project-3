@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Affiliate',
        'description' => 'You have questions? We have answers!'
    ])

    <section class="testimonial-2  section-padding">
        <img src="/images/testmonial-shape.png" alt="" class="anim-img">
        <img src="/images/testmonial-shape.png" alt="" class="anim-img anim-2">
        <div class="container">
           Affiliate page
        </div>
    </section>

@endsection
