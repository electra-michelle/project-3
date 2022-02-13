<?php
return [
    'basic' => [
        'name' => 'Basic',
        'period_type' => 'daily',
        'principal_return' => false,
        'affiliate_commission' => 3,
        'periods' => [
            [
                'period_start'	=>	1,
                'period_end'	=>	10,
                'interest'	=>	12,
            ]
        ],
        'limits' => [
            'USD' => [
                'min_amount' => 10,
                'max_amount' => 1000
            ],
            'LTC' => [
                'min_amount' => 10,
                'max_amount' => 1000
            ],
            'BCH' => [
                'min_amount' => 10,
                'max_amount' => 1000
            ],
            'BTC' => [
                'min_amount' => 10,
                'max_amount' => 1000
            ],
            'DOGE' => [
                'min_amount' => 10,
                'max_amount' => 1000
            ],
        ]
    ],
    'standard' => [
        'name' => 'Standard',
        'period_type' => 'daily',
        'principal_return' => false,
        'affiliate_commission' => 4,
        'periods' => [
            [
                'period_start'	=>	1,
                'period_end'	=>	20,
                'interest'	=>	7.5,
            ]
        ],
        'limits' => [
            'USD' => [
                'min_amount' => 10,
                'max_amount' => 1000
            ],
            'LTC' => [
                'min_amount' => 10,
                'max_amount' => 1000
            ],
            'BCH' => [
                'min_amount' => 10,
                'max_amount' => 1000
            ],
            'BTC' => [
                'min_amount' => 10,
                'max_amount' => 1000
            ],
            'DOGE' => [
                'min_amount' => 10,
                'max_amount' => 1000
            ],
        ]
    ],
    'professional' => [
        'name' => 'Professional',
        'period_type' => 'daily',
        'principal_return' => false,
        'affiliate_commission' => 5,
        'periods' => [
            [
                'period_start'	=>	1,
                'period_end'	=>	30,
                'interest'	=>	6.5,
            ]
        ],
        'limits' => [
            'USD' => [
                'min_amount' => 10,
                'max_amount' => 1000
            ],
            'LTC' => [
                'min_amount' => 10,
                'max_amount' => 1000
            ],
            'BCH' => [
                'min_amount' => 10,
                'max_amount' => 1000
            ],
            'BTC' => [
                'min_amount' => 10,
                'max_amount' => 1000
            ],
            'DOGE' => [
                'min_amount' => 10,
                'max_amount' => 1000
            ],
        ]
    ],
];
