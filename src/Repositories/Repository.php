<?php
namespace Rolice\LaravelCurrency\Repositories;

use Illuminate\Support\Facades\Config;
use Rolice\LaravelCurrency\ExchangeRate;
use Rolice\LaravelCurrency\Models\Currency;
use Rolice\LaravelCurrency\Exceptions\Exception;
use Rolice\LaravelCurrency\Exceptions\NotImplementedException;

abstract class Repository implements RepositoryInterface
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

    public function convert(ExchangeRate $rate, $auto_save = true)
    {
        $currency = Currency::findOrNew($rate->code);

        if (!$currency->exists) {
            $currency->base = $rate->base;
            $currency->code = $rate->code;
        }

        $currency->price = round($rate->price * pow(10, (int) Config::get('laravel-currency.laravel-currency.precision')));
        $currency->refreshed_at = $rate->refreshed_at;

        if ($auto_save) {
            if (!$currency->save()) {
                throw new Exception("Could not save converted currency {$rate->code}.");
            }
        }

        return $currency;
    }

    public function synchronize()
    {
        $currencies = $this->fetch();

        foreach ($currencies as $currency) {
            $this->convert($currency);
        }

        return Currency::all();
    }
}