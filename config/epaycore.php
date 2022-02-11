<?php

return [

    'api' => [
		'id' => env('EPC_API_ID'),
		'secret' => env('EPC_API_SECRET'),
        'description' => env('EPC_API_DESCRIPTION')
	],

    'sci' => [
		'id' => env('EPC_SCI_ID'),
		'password' => env('EPC_SCI_PASSWORD'),
        'description' => env('EPC_SCI_DESCRIPTION')
	],

	'currency' => env('EPC_CURRENCY', 'USD'),
	'success_url' => env('EPC_SUCCESS_URL'),
	'cancel_url' => env('EPC_CANCEL_URL'),
	'status_url' => env('EPC_STATUS_URL'),


    'commission' => env('EPC_COMMISSION', 2), // 1 - store pays commission | 2 - commission pays user
];
