<?php

return [

    'api' => [
		'id' => env('EPC_API_ID'),
		'secret' => env('EPC_API_SECRET'),
	],

    'sci' => [
		'id' => env('EPC_SCI_ID'),
		'password' => env('EPC_SCI_PASSWORD'),
	],

	'wallet' => env('EPC_WALLET'),
	'currency' => env('EPC_CURRENCY', 'USD'),
	'success_url' => env('EPC_SUCCESS_URL'),
	'cancel_url' => env('EPC_CANCEL_URL'),
	'status_url' => env('EPC_STATUS_URL'),


];
