<?php
namespace Rolice\LaravelCurrency\Repositories;

use Illuminate\Support\Facades\Config;

class YahooFinance extends Repository implements RepositoryInterface
{
    public function fetch()
    {
        $response = $this->call(Config::get('laravel-currency.repository.yahoo-finance.uri'));
        $response = $this->json($response);

        return $response;
    }

}