<?php

return [

    /*
     *
     */
    'test_mode' => env('HELLOSIGN_TEST_MODE', false),

    /*
     * Any templates you want to use with HelloSign
     */
    'templates' => [
        // 'contract' => '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8',
    ],

    /*
     *
     */
    'authentication' => [

        //  Method can be either 'key', 'email' or 'oauth'
        'method' => env('HELLOSIGN_API_METHOD', 'key'),

        'params' => [
            //  Required for 'api' method
            'api_key' => env('HELLOSIGN_API_KEY'),

            //  Required for 'email' method
            'email' => env('HELLOSIGN_API_EMAIL'),
            'password' => env('HELLOSIGN_API_PASSWORD'),

            //  Required for 'oauth' method
            'oauth_token' => env('HELLOSIGN_API_OAUTH_TOKEN'),
        ],
    ],

];
