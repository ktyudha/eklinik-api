<?php

return [
    'midtrans' => [
        'mercant_id' => env('MIDTRANS_MERCHAT_ID'),
        'serverKey'     => env('MIDTRANS_SERVERKEY'),
        'clientKey'     => env('MIDTRANS_CLIENTKEY'),
        'isProduction'  => env('MIDTRANS_IS_PRODUCTION', false),
        'isSanitized'   => env('MIDTRANS_IS_SANITIZED', false),
        'is3ds'         => env('MIDTRANS_IS_3DS', false),
    ],
];
