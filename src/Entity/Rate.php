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
     *
     * One Rate has one Source.
     * @ORM\OneToOne(targetEntity="Source")
     * @ORM\JoinColumn(name="source_id", referencedColumnName="id")
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

    public function __construct(
        string $source,
        string $baseCurrency,
        string $quoteCurrency,
        float $rate,
        DateTimeInterface $fromDate,
        int $weight
    ) {
        $this->source = $source;
        $this->baseCurrency = $baseCurrency;
        $this->quoteCurrency = $quoteCurrency;
        $this->rate = $rate;
        $this->fromDate = $fromDate;
        $this->weight = $weight;
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

    public function getFromDate(): DateTimeInterface
    {
        return $this->fromDate;
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