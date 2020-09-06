<?php
declare(strict_types=1);

namespace Iamvar\Rates\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * @ORM\Entity
 * @ORM\Table(name="rates")
 * @ORM\HasLifecycleCallbacks
 */
class Rate
{
    public const PROP_SOURCE = 'source';
    public const PROP_BASE_CURRENCY = 'baseCurrency';
    public const PROP_QUOTE_CURRENCY = 'quoteCurrency';
    public const PROP_FROM_DATE = 'fromDate';
    public const PROP_RATE = 'rate';
    public const PROP_WEIGHT = 'weight';

    /**
     * @ORM\Id
     * @ORM\Column(name="source", type="string")
     */
    private string $source;
    /**
     * @ORM\Id
     * @ORM\Column(name="base_currency", type="string")
     */
    private string $baseCurrency;
    /**
     * @ORM\Id
     * @ORM\Column(name="quote_currency", type="string")
     */
    private string $quoteCurrency;
    /**
     * @ORM\Id
     * @ORM\Column(name="from_date", type="stringable_date")
     */
    private DateTimeInterface $fromDate;
    /**
     * @ORM\Column(name="rate", type="float")
     */
    private float $rate;
    /**
     * @ORM\Column(name="weight", type="integer")
     */
    private int $weight;
    /**
     * @ORM\Column(name="created", type="datetime")
     */
    private DateTimeInterface $created;
    /**
     * @ORM\Column(name="updated", type="datetime")
     */
    private DateTimeInterface $updated;

    public function __construct(string $baseCurrency, string $quoteCurrency, float $rate, DateTimeInterface $fromDate)
    {
        $this->baseCurrency = $baseCurrency;
        $this->quoteCurrency = $quoteCurrency;
        $this->rate = $rate;
        $this->fromDate = $fromDate;
    }

    /**
     * @ORM\PrePersist
     *
     * @throws Exception;
     */
    public function onPrePersist(): void
    {
        $this->created = new DateTime('NOW');
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate(): void
    {
        $this->updated = new DateTime('NOW');
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;
        return $this;
    }

    public function getCreated(): DateTimeInterface
    {
        return $this->created;
    }

    public function getUpdated(): DateTimeInterface
    {
        return $this->updated;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;
        return $this;
    }

    public function getFromDate(): DateTimeInterface
    {
        return $this->fromDate;
    }

    public function setFromDate(DateTime $fromDate): self
    {
        $this->fromDate = $fromDate;
        return $this;
    }

    public function getBaseCurrency(): string
    {
        return $this->baseCurrency;
    }

    public function setBaseCurrency(string $baseCurrency): self
    {
        $this->baseCurrency = $baseCurrency;
        return $this;
    }

    public function getQuoteCurrency(): string
    {
        return $this->quoteCurrency;
    }

    public function setQuoteCurrency(string $quoteCurrency): self
    {
        $this->quoteCurrency = $quoteCurrency;
        return $this;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;
        return $this;
    }

    public function getPrimaryKeyArray(): array
    {
        return [
            self::PROP_SOURCE => $this->getSource(),
            self::PROP_BASE_CURRENCY => $this->getBaseCurrency(),
            self::PROP_QUOTE_CURRENCY => $this->getQuoteCurrency(),
            self::PROP_FROM_DATE => $this->getFromDate(),
        ];
    }
}