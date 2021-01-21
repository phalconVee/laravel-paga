<?php

return [

    /**
     * API Key From Paga Dashboard
     */
    'apiKey' => env('PAGA_HMAC_API_KEY'),

    /**
     * Public Key From Paga Dashboard
     */
    'publicKey' => env('PAGA_PUBLIC_KEY'),

    /**
     * Secret Key / Credentials From Paga Dashboard
     */
    'secretKey' => env('PAGA_SECRET_KEY')
];
