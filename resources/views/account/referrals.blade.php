@extends('layouts.app')

@section('content')
    @include('layouts.breadcrumb', [
        'title' => 'Referrals',
        'description' => '12321321'
    ])
    @include('account.__partials.nav')

    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-3">
                    @include('account.__partials.ref_link')
                </div>
                <div class="col-lg-6 mb-2">
                    <div class="quick-call">
                        <div class="mb-3"><span><i class="fas fa-users"></i></span></div>
                        <div class="qc-txt">
                            <p>Total Referrals</p>
                            <h4>{{ $totalReferrals }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2">
                    <div class="quick-call">
                        <div class="mb-3"><span><i class="fas fa-user-check"></i></span></div>
                        <div class="qc-txt">
                            <p>Active Referrals</p>
                            <h4>{{ $activeReferrals }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive mt-3">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Joined</th>
                        <th>Username</th>
                        <th>Deposited</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($referrals))
                        @foreach($referrals as $referral)
                            <tr>
                                <td>{{ $referral->created_at }}</td>
                                <td>{{ $referral->username }}</td>
                                <td>
                                    @if(count($referral->depositSum))
                                        @foreach($referral->depositSum as $depositSum)
                                            {{ round($depositSum->total_deposit, $depositSum->decimals) }} {{ $depositSum->currency }}
                                            @if (!$loop->last)
                                                <span>/</span>
                                            @endif
                                        @endforeach
                                    @else
                                        0 USD
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-center">Referral list is empty</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>

            {{ $referrals->links('layouts.pagination') }}
        </div>
    </section>
@endsection
