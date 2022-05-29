<?php
declare(strict_types=1);

namespace Iamvar\Rates\RateLoader\Service\RateSource;

use Iamvar\Rates\RateLoader\DTO\RateDTO;
use Iamvar\Rates\RateLoader\DTO\RateDTOCollection;
use Iamvar\Rates\RateLoader\RateSourceInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * parses json content from api.coindesk.com for BTC -> USD rate
 * {
 * "bpi":{
 * "2020-09-03":11302.8875,
 * "2020-09-04":10292.5983
 * },
 * "disclaimer":"This data was produced from the CoinDesk Bitcoin Price Index. BPI value data returned as USD.",
 * "time":{
 * "updated":"May 5, 2022 00:03:00 UTC",
 * "updatedISO":"2022-05-05T00:03:00+00:00"
 * }
 * }
 */
class CoindeskRateSource implements RateSourceInterface
{
    private const DEFAULT_URL = 'https://api.coindesk.com/v1/bpi/historical/close.json';
    private const BASE_CURRENCY = 'BTC';
    private const QUOTE_CURRENCY = 'USD';

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $url = self::DEFAULT_URL,
    )
    {
    }

    public static function getName(): string
    {
        return 'coindesk';
    }

    public function getRates(): RateDTOCollection
    {
        $rates = [];
        foreach ($this->parseContent() as $date => $rate) {
            $rates[] = new RateDTO(
                self::BASE_CURRENCY,
                self::QUOTE_CURRENCY,
                (string)$rate,
                new \DateTimeImmutable($date)
            );
        }

        return new RateDTOCollection(...$rates);
    }

    private function parseContent(): array
    {
        $response = $this->client->request('GET', $this->url);

        $contentArray = $response->toArray();
        if (!isset($contentArray['bpi']) || !is_array($contentArray['bpi'])) {
            throw new \UnexpectedValueException('Could not find bpi section in json');
        }

        return $contentArray['bpi'];
    }
}
