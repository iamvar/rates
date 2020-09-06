<?php
declare(strict_types=1);

namespace Iamvar\Rates\Entity;

use ArrayIterator;
use IteratorAggregate;

class Rates implements IteratorAggregate
{
    private $rates;

    public function __construct(Rate ...$rates) {
        $this->rates = $rates;
    }

    /**
     * @return ArrayIterator|Rate[]
     */
    public function getIterator() {
        return new ArrayIterator($this->rates);
    }
}