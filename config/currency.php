<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Currency
    |--------------------------------------------------------------------------
    |
    | Cette configuration définit la devise par défaut utilisée dans l'application.
    | TND = Dinar Tunisien
    |
    */

    'default' => 'TND',

    'currencies' => [
        'TND' => [
            'name' => 'Dinar Tunisien',
            'symbol' => 'TND',
            'code' => 'TND',
            'precision' => 2,
            'format' => '%s %s', // amount symbol
        ],
        'EUR' => [
            'name' => 'Euro',
            'symbol' => '€',
            'code' => 'EUR',
            'precision' => 2,
            'format' => '%s%s', // amount symbol
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Conversion Rates (approximate)
    |--------------------------------------------------------------------------
    |
    | Taux de change approximatifs pour référence
    |
    */
    'rates' => [
        'EUR_to_TND' => 3.3,
        'TND_to_EUR' => 0.30,
    ],

    /*
    |--------------------------------------------------------------------------
    | Regional Information
    |--------------------------------------------------------------------------
    |
    | Informations spécifiques à la Tunisie
    |
    */
    'region' => [
        'country' => 'Tunisie',
        'country_code' => 'TN',
        'phone_prefix' => '+216',
        'phone_format' => '+216 XX XXX XXX',
        'postal_code_format' => 'XXXX',
        'timezone' => 'Africa/Tunis',
    ],
];