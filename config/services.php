<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => 'mg.sportamails.be',
        'secret' => 'key-196809cbd178b5bad1f89a854411daf2',
    ],

    'flickr' => [
        'key' => 'f43b17b18146e4cddb039937a70acc6c',
        'secret' => '606914364a25550b',
        'userid' => '67259477@N02'
    ],

    'mandrill' => [
        'secret' => '',
    ],

    'ses' => [
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model' => 'App\User',
        'secret' => '',
    ],

];
