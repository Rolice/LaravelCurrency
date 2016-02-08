<?php
namespace Rolice\LaravelCurrency\Repositories;

use Rolice\LaravelCurrency\Exceptions\NotImplementedException;
use Rolice\LaravelCurrency\ExchangeRate;
use Rolice\LaravelCurrency\Models\Currency;

abstract class Repository
{
    /**
     * The curl handle to be used by the repository to call external api services.
     * @var resource
     */
    protected $curl = null;

    public function __construct()
    {
        $this->curl = curl_init();

        curl_setopt_array($this->curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
    }

    public function __destruct()
    {
        $this->close();
    }

    public function close()
    {
        if ($this->curl && is_resource($this->curl)) {
            curl_close($this->curl);
        }

        $this->curl = null;
    }

    public function url($url)
    {
        curl_setopt($this->curl, CURLOPT_URL, $url);
    }

    public function call($url = null)
    {
        if ($url) {
            $this->url($url);
        }

        return curl_exec($this->curl);
    }

    protected function json($response)
    {
        return json_decode($response);
    }

    protected function xml($response)
    {
        throw new NotImplementedException;
    }

    protected function csv($response)
    {
        throw new NotImplementedException;
    }

    public function convert(ExchangeRate $rate)
    {
        $currency = new Currency;
        $currency->base = $rate->source;
        $currency->code = $rate->target;
        $currency->price = $rate->price;
        $currency->refreshed_at = $rate->updated_at;

        return $currency;
    }
}