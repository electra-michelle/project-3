<?php

return [
    'registration' => 'Registered as <b>' . config('app.name') . '</b> Member',
    'withdraw_complete' => 'Withdraw request <strong>#:id</strong> for <b>:amount :currency</b> to <b>:payment_system</b> wallet has been successfully processed. <br>Transaction id: <strong>:transaction_id<strong>',
    'withdraw_request' => 'Created withdrawal request <strong>#:id</strong> for <b>:amount :currency</b> to <b>:payment_system</b> Account',
    'commission_earned' => 'New Referral Commission Earning (<b>:amount :currency</b>) from <b>:from_user</b> which deposited <strong>#:from_deposit</strong> has been added to <b>:payment_system</b> Balance',
    'daily_income' => 'Daily income <b>:amount :currency</b> from deposit <strong>#:deposit_id</strong>  has been added to <b>:payment_system</b> balance.',
    'new_referral' => 'New Referral (downline) - <b>:username</b>',
    'new_investment' => 'Created new Investment <strong>#:id</strong> in <b>:plan</b> for :amount :currency (:payment_system)</b>.',
    'plan_finished' => 'Investments (<b>#:id</b>) status has been changed to Completed',
    'settings_updated' => 'Account settings has been updated.',
    'principals_returned' => 'Principals of <strong>:amount :currency</strong> from <strong>#:deposit_id</strong> has been counted to :payment_system balance.',
];
