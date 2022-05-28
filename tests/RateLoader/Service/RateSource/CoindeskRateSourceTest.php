<?php
declare(strict_types=1);

namespace Iamvar\Rates\Tests\RateLoader\Service\RateSource;

use Iamvar\Rates\RateLoader\DTO\RateDTO;
use Iamvar\Rates\RateLoader\Service\RateSource\CoindeskRateSource;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class CoindeskRateSourceTest extends TestCase
{
    public function testGettingRates(): void
    {
        $response = <<<RESPONSE
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
RESPONSE;
        $client = new MockHttpClient([
            new MockResponse($response),
        ]);

        $repository = new CoindeskRateSource($client);
        $rate1 = new RateDTO('BTC', 'USD', '11302.8875', new \DateTimeImmutable('2020-09-03'));
        $rate2 = new RateDTO('BTC', 'USD', '10292.5983', new \DateTimeImmutable('2020-09-04'));
        $expected = new RatesDTO($rate1, $rate2);
        $this->assertEquals($expected, $repository->getRates());
    }
}
