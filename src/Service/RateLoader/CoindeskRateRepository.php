<?php
declare(strict_types=1);

namespace Iamvar\Rates\Service\RateLoader;

use DateTimeImmutable;
use Iamvar\Rates\Entity\DateTimeStringable;
use Iamvar\Rates\Entity\Rate;
use Iamvar\Rates\Entity\Rates;
use Iamvar\Rates\Service\RateLoader\Exception\ParseException;

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

    private $url;
    private $contentObtainer;

    public function __construct(ContentObtainerInterface $contentObtainer, string $url = self::DEFAULT_URL)
    {
        $this->url = $url;
        $this->contentObtainer = $contentObtainer;
    }

    public function getRates(): Rates
    {
        $json = $this->contentObtainer->getContent($this->url);

        $ratesArray = [];
        foreach ($this->parseContent($json) as $date => $rate) {
            $ratesArray[] = new Rate(
                self::BASE_CURRENCY,
                self::QUOTE_CURRENCY,
                (float)$rate,
                new DateTimeStringable($date)
            );
        }

        return new Rates(...$ratesArray);
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