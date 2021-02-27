<?php
declare(strict_types=1);

namespace Iamvar\Rates\Services\RateLoader\DTO;

use ArrayIterator;
use IteratorAggregate;

class RatesDTO implements IteratorAggregate
{
    private array $rates;

    public function __construct(RateDTO ...$rates) {
        $this->rates = $rates;
    }

    /**
     * @return ArrayIterator|RateDTO[]
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->rates);
    }
}
