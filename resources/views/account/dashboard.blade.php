@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Dashboard',
        'description' => '12321321'
    ])
    @include('account.__partials.nav')

    <section class="section-padding">
        <div class="container">
            Affiliate link: {{ route('home', ['ref' => $user->ref_url]) }}
        </div>
    </section>
@endsection
