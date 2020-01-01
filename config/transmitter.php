<?php

return [
    /**
     *
     * Should implement '\Media365\Transmitter\Services\SMS'
     * Available drivers are Textvertising, LogSMS
     */
    'driver' => \Media365\Transmitter\Services\Textvertising::class,


    'drivers' => [
        'textvertising' => [
            "url" => env('TEXTVERTISING_URL', "https://www.textvertising.co.uk/_admin/api/send_sms.asp"),
            'sender' => env('TEXTVERTISING_SENDER', 'Media365'),
            "username" => env('TEXTVERTISING_USERNAME'),
            "password" => env('TEXTVERTISING_PASSWORD'),
            'api_key' => env('TEXTVERTISING_API_KEY'),
        ]
    ]
];
