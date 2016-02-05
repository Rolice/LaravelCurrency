<?php
namespace Rolice\LaravelCurrency;

use DateTime;
use Rolice\LaravelCurrency\Exceptions\Exception;

class ExchangeRate
{

    /**
     * The base currency
     * @var string[3]
     */
    protected $source = null;

    /**
     * The priced currency in the exchange rate
     * @var string[3]
     */
    protected $target = null;

    /**
     * The price of the exchange for single unit of the base currency
     * @var float
     */
    protected $price = 0.00;

    /**
     * The exchange rate freshness as last update datetime
     * @var DateTime
     */
    protected $updated_at = null;

    public function __construct($source, $target, $price, DateTime $update_at)
    {
        $this->source = $source;
        $this->target = $target;
        $this->price = $price;
        $this->updated_at = $update_at;
    }

    public function __get($name)
    {
        return isset($this->$name) ? $this->$name : null;
    }

    public function __set($name, $value)
    {
        throw new Exception('The ' . __CLASS__ . ' class is read-only. You cannot set any properties to it.');
    }

}