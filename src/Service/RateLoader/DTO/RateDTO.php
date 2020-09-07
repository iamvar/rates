<?php
declare(strict_types=1);

namespace Iamvar\Rates\Service\RateLoader\DTO;

use DateTimeInterface;

class RateDTO
{
    private string $baseCurrency;
    private string $quoteCurrency;
    private float $rate;
    private DateTimeInterface $date;

    public function __construct(string $baseCurrency, string $quoteCurrency, float $rate, DateTimeInterface $date)
    {
        $this->baseCurrency = $baseCurrency;
        $this->quoteCurrency = $quoteCurrency;
        $this->rate = $rate;
        $this->date = $date;
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

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }
}