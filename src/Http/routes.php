<?php

Route::group(['prefix' => 'currency'], function () {
    Route::get('/', ['as' => 'currency.index', 'uses' => 'Rolice\LaravelCurrency\Http\Controllers\CurrencyController@index']);
});