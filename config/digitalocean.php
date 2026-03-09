<?php

return [

    'default' => 'main',

    'connections' => [

        'main' => [
            'token' => env('DIGITALOCEAN_TOKEN'),
        ],

        'alternative' => [
            'token' => env('DIGITALOCEAN_TOKEN'),
        ],

    ],

];