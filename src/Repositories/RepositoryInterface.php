<?php
namespace Rolice\LaravelCurrency\Repositories;

use Rolice\LaravelCurrency\ExchangeRate;
use Rolice\LaravelCurrency\ExchangeRateCollection;
use Rolice\LaravelCurrency\Models\Currency;

interface RepositoryInterface
{

    /**
     * Returns a raw exchange rate collection with rates relevant to the current moment.
     * @return ExchangeRateCollection
     */
    public function fetch();

    /**
     * Converts raw ExchangeRate to system-specific database model.
     * @param ExchangeRate $rate The rate to be converted to currency model.
     * @param bool $auto_save Whether to automatically save the model or not.
     * @return Currency The resulting model
     */
    public function convert(ExchangeRate $rate, $auto_save = true);

}