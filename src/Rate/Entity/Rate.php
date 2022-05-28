<?php
declare(strict_types=1);

namespace Iamvar\Rates\Rate\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'rates')]
#[ORM\HasLifecycleCallbacks]
class Rate
{
    #[ORM\Id]
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: ['comment' => 'date when the rate was set'])]
    private DateTimeInterface $fromDate;

    #[ORM\Id]
    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $baseCurrency; // It was 3 chars length using ISO 4217, but because of crypto, it was increased

    #[ORM\Id]
    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $quoteCurrency; // It was 3 chars length using ISO 4217, but because of crypto, it was increased

    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: Source::class)]
    #[ORM\JoinColumn(name: 'source', referencedColumnName: 'name')]
    private string $source;

    #[ORM\Column(type: Types::DECIMAL)]
    private float $rate;

    #[ORM\Column(type: Types::SMALLINT, options: ['unsigned' => true, 'comment' => 'bigger weight will be considered in case of concurrent rates from different sources'])]
    private int $weight;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeInterface $created;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
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

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->created = new DateTime('NOW');
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updated = new DateTime('NOW');
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

    public function getRate(): float
    {
        return $this->rate;
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

    public function getSource(): string
    {
        return $this->source;
    }
}
