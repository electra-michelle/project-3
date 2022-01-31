@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Make deposit',
        'description' => '12321321'
    ])
    @include('account.__partials.nav')

    <section class="section-padding">
        <div class="container">
            Details of {{ $deposit->id }}
        </div>
    </section>
@endsection
