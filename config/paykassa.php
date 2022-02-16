<?php

return [

    'api' => [
        'id' => env('PAYKASSA_API_ID'),
        'secret' => env('PAYKASSA_API_PASSWORD')
    ],

    'sci' => [
        'id' => env('EPC_SCI_ID'),
        'password' => env('PAYKASSA_SCI_PASSWORD'),
    ],

];
