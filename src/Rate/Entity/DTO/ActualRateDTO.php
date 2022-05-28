<?php
declare(strict_types=1);

namespace Iamvar\Rates\Entity\DTO;

class ActualRateDTO
{
    public function __construct(
        public readonly string $baseCurrency,
        public readonly string $quoteCurrency,
        public readonly string $rate,
    ) {
    }
}
