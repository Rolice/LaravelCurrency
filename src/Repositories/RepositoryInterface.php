<?php
namespace Rolice\LaravelCurrency\Repositories;

use Rolice\LaravelCurrency\ExchangeRateCollection;

interface RepositoryInterface {

    /**
     * Returns a raw exchange rate collection with rates relevant to the current moment.
     * @return ExchangeRateCollection
     */
    public function fetch();

}