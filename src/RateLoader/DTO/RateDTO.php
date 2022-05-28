<?php
declare(strict_types=1);

namespace Iamvar\Rates\RateLoader\DTO;

use DateTimeInterface;

class RateDTO
{
    public function __construct(
        public readonly string $baseCurrency,
        public readonly string $quoteCurrency,
        public readonly string $rate,
        public readonly DateTimeInterface $date,
    ) {
    }
}
