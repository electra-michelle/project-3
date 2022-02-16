<?php

return [

    'api' => [
        'id' => env('PAYKASSA_API_ID'),
        'password' => env('PAYKASSA_API_PASSWORD'),
        'description' => env('PAYKASSA_API_DESCRIPTION'),
    ],

    'sci' => [
        'id' => env('PAYKASSA_SCI_ID'),
        'password' => env('PAYKASSA_SCI_PASSWORD'),
        'description' => env('PAYKASSA_SCI_DESCRIPTION'),
    ],
	
	'test' => env('PAYKASSA_TEST', false),

	'crypto' => [
		'tron_trc20_usdt'
	]
];
