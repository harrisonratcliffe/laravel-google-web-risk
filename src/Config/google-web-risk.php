<?php

use Aws\Laravel\AwsServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel Google Web Risk Configuration
    |--------------------------------------------------------------------------
    | Many of these entries can be left as default unless you want something different, however
    | the Google API key is required.
    |
    | IMPORTANT: Google Web Risk free tier is limited to 100k requests per month.
    |
    | For more information on options:
    |
    | Threat Types: https://cloud.google.com/web-risk/docs/reference/rest/v1beta1/ThreatType
    */

    'google' => [
        'api_key' => env('GOOGLE_API_KEY'),
        'timeout' => 10,
        'threat_types' => [
            'MALWARE',
            'SOCIAL_ENGINEERING',
            'UNWANTED_SOFTWARE',
            'SOCIAL_ENGINEERING_EXTENDED_COVERAGE',
        ],
    ],

];
