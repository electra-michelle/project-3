<?php

return [

    'email' => [
        'enabled' => true,
        'categories' => [
            'settings_updated' => true,
            'registered' => true,
            'withdraw' => true,
            'profit_added' => true,
            'deposit_confirmed' => true,
            'deposit_finished' => true,
            'principals_returned' => true,
            'ref_commission' => true,
            'new_referral' => true,
        ]
    ],
    // User for live notifications
    'broadcast' => [
        'enabled' => true,
        'categories' => [
            'new_account' => true,
            'new_deposit' => true,
            'ref_commission' => true,
            'withdraw' => true,
        ]
    ]
];
