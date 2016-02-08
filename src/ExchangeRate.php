<?php
namespace Rolice\LaravelCurrency;

use Carbon\Carbon;
use Rolice\LaravelCurrency\Exceptions\Exception;

class ExchangeRate
{

    /**
     * The base currency code.
     * @var string[3]
     */
    public $base = null;

    /**
     * The targeted currency code.
     * @var string[3]
     */
    public $code = null;

    /**
     * The price of the exchange for single unit of the base currency
     * @var float
     */
    public $price = 0.00;

    /**
     * The exchange rate freshness as last update datetime
     * @var Carbon
     */
    public $refreshed_at = null;

    public function __construct($base, $code, $price, Carbon $refreshed_at)
    {
        $this->base = $base;
        $this->code = $code;
        $this->price = $price;
        $this->refreshed_at = $refreshed_at;
    }

    public function __set($name, $value)
    {
        throw new Exception('The ' . __CLASS__ . ' class is read-only. You cannot set any properties to it.');
    }

}