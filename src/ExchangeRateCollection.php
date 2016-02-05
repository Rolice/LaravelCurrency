<?php
namespace Rolice\LaravelCurrency;

use Traversable;
use InvalidArgumentException;
use Illuminate\Support\Collection;
use Rolice\LaravelCurrency\Exceptions\Exception;

class ExchangeRateCollection extends Collection
{
    public function __construct($items = [])
    {
        if (!is_array($items) && !$items instanceof Traversable) {
            throw new InvalidArgumentException;
        }

        foreach ($items as $item) {
            if (!($item instanceof ExchangeRate)) {
                throw new Exception('Only ExchangeRate objects can be added to a ExchangeRate collection.');
            }
        }

        parent::__construct($items);
    }

    /**
     * Add an item to the collection.
     *
     * @param  mixed $item
     * @return $this
     */
    public function add(ExchangeRate $item)
    {
        $this->items[] = $item;

        return $this;
    }
}