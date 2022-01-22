<?php

return [

    'bitcoin'	=>	[
        'host' => env('BITCOIN_RPC_HOST', 'localhost'),
        'username' => env('BITCOIN_RPC_USERNAME'),
        'password' => env('BITCOIN_RPC_PASSWORD'),
        'port' => env('BITCOIN_RPC_PORT', 8332),
        'wallet' => env('BITCOIN_RPC_WALLET'),
        'account' => env('BITCOIN_RPC_ACCOUNT'),
    ],

    'bitcoincash'	=>	[
        'host' => env('BITCOIN_CASH_RPC_HOST', 'localhost'),
        'username' => env('BITCOIN_CASH_RPC_USERNAME'),
        'password' => env('BITCOIN_CASH_RPC_PASSWORD'),
        'port' => env('BITCOIN_CASH_RPC_PORT', 8332),
        'wallet' => env('BITCOIN_CASH_RPC_WALLET'),
        'account' => env('BITCOIN_CASH_RPC_ACCOUNT'),
    ],

    'litecoin'	=>	[
        'host' => env('LITECOIN_RPC_HOST', 'localhost'),
        'username' => env('LITECOIN_RPC_USERNAME'),
        'password' => env('LITECOIN_RPC_PASSWORD'),
        'port' => env('LITECOIN_RPC_PORT', 9432),
        'wallet' => env('LITECOIN_RPC_WALLET'),
        'account' => env('LITECOIN_RPC_ACCOUNT'),
    ],

    'dogecoin'	=>	[
        'host' => env('DOGECOIN_RPC_HOST', 'localhost'),
        'username' => env('DOGECOIN_RPC_USERNAME'),
        'password' => env('DOGECOIN_RPC_PASSWORD'),
        'port' => env('DOGECOIN_RPC_PORT', 22555),
        'wallet' => env('DOGECOIN_RPC_WALLET'),
        'account' => env('DOGECOIN_RPC_ACCOUNT'),
    ],

    'dash'	=>	[
        'host' => env('DASH_RPC_HOST', 'localhost'),
        'username' => env('DASH_RPC_USERNAME'),
        'password' => env('DASH_RPC_PASSWORD'),
        'port' => env('DASH_RPC_PORT', 9998),
        'wallet' => env('DASH_RPC_WALLET'),
        'account' => env('DASH_RPC_ACCOUNT'),
    ],
];
