<section class="account-nav">
    <div class="container">
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link{{ Route::currentRouteName() == 'account.dashboard' ? ' active' : null }}" href="{{ route('account.dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ Route::currentRouteName() == 'account.deposit' ? ' active' : null }}" href="{{ route('account.deposit') }}">Make deposit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'account.withdraw' ? ' active' : null }}" href="{{ route('account.withdraw') }}">Withdraw</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'account.referral' ? ' active' : null }}" href="{{ route('account.referral') }}">Referrals</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'account.banners' ? ' active' : null }}" href="{{ route('account.banners') }}">Marketing tools</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'account.settings' ? ' active' : null }}" href="{{ route('account.settings') }}">Settings</a>
            </li>
        </ul>
    </div>
</section>
