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
     * @ORM\Column(name="from_date", type="stringable_date", options={"comment":"date when the rate was set"})
     */
    private DateTimeInterface $fromDate;

    /**
     * @ORM\Id
     * @ORM\Column(name="base_currency", type="string", length=3, options={"fixed":true, "comment":"base currency in ISO 4217"})
     */
    private string $baseCurrency;

    /**
     * @ORM\Id
     * @ORM\Column(name="quote_currency", type="string", length=3, options={"fixed":true, "comment":"quote currency in ISO 4217"})
     */
    private string $quoteCurrency;

    /**
     * @ORM\Id
     *
     * One Rate has one Source.
     * @ORM\OneToOne(targetEntity="Source")
     * @ORM\JoinColumn(name="source", referencedColumnName="name")
     */
    private string $source;

    /**
     * @ORM\Column(name="rate", type="float")
     */
    private float $rate;

    /**
     * @ORM\Column(name="weight", type="integer", options={"comment":"bigger weight will be considered in case of concurrent rates from different sources"})
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
        int $weight,
    ) {
        $this->fromDate = new DateTimeStringable($fromDate->format(DATE_ATOM));
        $this->baseCurrency = $baseCurrency;
        $this->quoteCurrency = $quoteCurrency;
        $this->source = $source;
        $this->rate = $rate;
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
            self::PROP_FROM_DATE => $this->getFromDate(),
            self::PROP_BASE_CURRENCY => $this->getBaseCurrency(),
            self::PROP_QUOTE_CURRENCY => $this->getQuoteCurrency(),
            self::PROP_SOURCE => $this->getSource(),
        ];
    }
}
