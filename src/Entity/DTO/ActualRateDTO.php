<?php
declare(strict_types=1);

namespace Iamvar\Rates\Entity\DTO;

class ActualRateDTO
{

    public function __construct(
        private string $baseCurrency,
        private string $quoteCurrency,
        private float $rate,
    ) {
    }

    public function getBaseCurrency(): string
    {
        return $this->baseCurrency;
    }

    public function getQuoteCurrency(): string
    {
        return $this->quoteCurrency;
    }

    public function getRate(): float
    {
        return $this->rate;
    }
}
