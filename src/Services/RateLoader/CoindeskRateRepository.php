<?php
declare(strict_types=1);

namespace Iamvar\Rates\Services\RateLoader;

use DateTimeImmutable;
use Iamvar\Rates\Services\RateLoader\DTO\RateDTO;
use Iamvar\Rates\Services\RateLoader\DTO\RatesDTO;
use Iamvar\Rates\Services\RateLoader\Exception\ParseException;

/**
 * parses json content from api.coindesk.com for BTC -> USD rate
{
  "bpi":{
    "2020-09-03":11302.8875,
    "2020-09-04":10292.5983
  },
  "disclaimer":"This data was produced from the CoinDesk Bitcoin Price Index. BPI value data returned as USD.",
  "time":{
    "updated":"Sep 5, 2020 00:03:00 UTC",
    "updatedISO":"2020-09-05T00:03:00+00:00"
  }
}
 */
class CoindeskRateRepository implements RateRepositoryInterface
{
    private const DEFAULT_URL = 'https://api.coindesk.com/v1/bpi/historical/close.json';
    private const BASE_CURRENCY = 'BTC';
    private const QUOTE_CURRENCY = 'USD';

    public function __construct(
        private ContentObtainerInterface $contentObtainer,
        private string $url = self::DEFAULT_URL,
    ) {
    }

    public function getRates(): RatesDTO
    {
        $json = $this->contentObtainer->getContent($this->url);

        $rates = [];
        foreach ($this->parseContent($json) as $date => $rate) {
            $rates[] = new RateDTO(
                self::BASE_CURRENCY,
                self::QUOTE_CURRENCY,
                (float)$rate,
                new DateTimeImmutable($date)
            );
        }

        return new RatesDTO(...$rates);
    }

    private function parseContent(string $json): array
    {
        $contentArray = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        if (!isset($contentArray['bpi']) || !is_array($contentArray['bpi'])) {
            throw new ParseException('Could not find bpi section in json');
        }

        return $contentArray['bpi'];
    }
}