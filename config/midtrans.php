<?php

return [
    'mercantId'     => env('MIDTRANS_MERCHAT_ID'),
    'serverKey'     => env('MIDTRANS_SERVER_KEY'),
    'clientKey'     => env('MIDTRANS_CLIENT_KEY'),
    'isProduction'  => env('MIDTRANS_IS_PRODUCTION', false),
    'isSanitized'   => env('MIDTRANS_IS_SANITIZED', false),
    'is3ds'         => env('MIDTRANS_IS_3DS', false),
];
