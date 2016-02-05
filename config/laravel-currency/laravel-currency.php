<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you should specify the database connection to be used as storage for
    | the extracted currency exchange rates. This is mandatory config.
    |
    */

    'connection' => 'target database name',

    /*
    |--------------------------------------------------------------------------
    | Currency Repository
    |--------------------------------------------------------------------------
    |
    | Selected currency repository to be used for external information calls.
    |
    */

    'repository' => \Rolice\LaravelCurrency\Repositories\YahooFinance::class,

];