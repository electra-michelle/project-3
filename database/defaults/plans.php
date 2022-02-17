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
                'min_amount' => 0.08,
                'max_amount' => 8
            ],
            'BCH' => [
                'min_amount' => 0.03,
                'max_amount' => 3
            ],
            'BTC' => [
                'min_amount' => 0.001,
                'max_amount' => 0.025
            ],
            'DOGE' => [
                'min_amount' => 65,
                'max_amount' => 6500
            ],
            'USDT' => [
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
                'max_amount' => 5000
            ],
            'USDT' => [
                'min_amount' => 10,
                'max_amount' => 5000
            ],
            'LTC' => [
                'min_amount' => 0.08,
                'max_amount' => 40
            ],
            'BCH' => [
                'min_amount' => 0.03,
                'max_amount' => 15
            ],
            'BTC' => [
                'min_amount' => 0.001,
                'max_amount' => 0.125
            ],
            'DOGE' => [
                'min_amount' => 65,
                'max_amount' => 32500
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
                'max_amount' => 10000
            ],
            'USDT' => [
                'min_amount' => 10,
                'max_amount' => 10000
            ],
            'LTC' => [
                'min_amount' => 0.08,
                'max_amount' => 80
            ],
            'BCH' => [
                'min_amount' => 0.03,
                'max_amount' => 30
            ],
            'BTC' => [
                'min_amount' => 0.001,
                'max_amount' => 0.25
            ],
            'DOGE' => [
                'min_amount' => 65,
                'max_amount' => 65000
            ],
        ]
    ],
];
