<?php
namespace Rolice\LaravelCurrency\Repositories;

use DateTimeZone;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Rolice\LaravelCurrency\ExchangeRate;
use Rolice\LaravelCurrency\ExchangeRateCollection;
use Rolice\LaravelCurrency\Exceptions\IncorrectResponseException;

class YahooFinance extends Repository implements RepositoryInterface
{

    private function create($resource)
    {
        $name = explode('/', isset($resource->fields->name) ? $resource->fields->name : '');
        $price = isset($resource->fields->price) ? $resource->fields->price : 0.00;
        $date = isset($resource->fields->utctime) ? $resource->fields->utctime : null;
        $date = Carbon::createFromFormat('Y-m-dTH:i:s+0000', $date, DateTimeZone::UTC);

        if (2 > count($name)) {
            throw new IncorrectResponseException('Cannot fetch source/target currencies.');
        }

        if (0 >= $price) {
            throw new IncorrectResponseException('Currency exchange rate has wrong price.');
        }

        if (!$date) {
            throw new IncorrectResponseException('The last update date for exchange rate is missing or wrong.');
        }

        return new ExchangeRate($name[0], $name[1], $price, $date);
    }

    public function fetch()
    {
        $response = $this->call(Config::get('laravel-currency.repository.yahoo-finance.uri'));
        $response = $this->json($response);

        if (!$response) {
            throw new IncorrectResponseException('No or wrongly formatted response received.');
        }

        if (!isset($response->list->resources) || !is_array($response->list->resources)) {
            throw new IncorrectResponseException('The location of exchange rates in response is not found.');
        }

        $result = new ExchangeRateCollection;

        foreach ($this->list->resources as $resource) {
            $result->add($this->create($resource));
        }

        return $result;
    }

}