<?php

return [

    'api' => [
        'id' => env('PAYKASSA_API_ID'),
        'password' => env('PAYKASSA_API_PASSWORD')
    ],

    'sci' => [
        'id' => env('PAYKASSA_SCI_ID'),
        'password' => env('PAYKASSA_SCI_PASSWORD'),
    ],
	
	'test' => env('PAYKASSA_TEST', false)

];
