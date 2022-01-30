@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Referrals',
        'description' => '12321321'
    ])
    @include('account.__partials.nav')

    <section class="section-padding">
        <div class="container">
            <div class="table-responsive">
                <table class="table table-striped" >
                    <thead>
                    <tr>
                        <th>Joined</th>
                        <th>Username</th>
                        <th>Deposited</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($referrals as $referral)
                            <tr>
                                <td width="250">{{ $referral->created_at }}</td>
                                <td>{{ $referral->username }}</td>
                                <td>
                                    @if(count($referral->depositSum))
                                        @foreach($referral->depositSum as $depositSum)
                                            {{ round($depositSum->total_deposit, $depositSum->decimals) }} {{ $depositSum->currency }}
                                            @if (!$loop->last)
                                                <span class="visible-xs-inline">/</span>
                                            @endif
                                        @endforeach
                                    @else
                                        0 USD
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $referrals->links('layouts.pagination') }}
        </div>
    </section>
@endsection
