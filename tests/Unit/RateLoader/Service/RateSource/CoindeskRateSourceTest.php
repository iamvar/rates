<?php
declare(strict_types=1);

namespace Iamvar\Rates\Tests\Unit\RateLoader\Service\RateSource;

use Iamvar\Rates\RateLoader\DTO\RateDTO;
use Iamvar\Rates\RateLoader\DTO\RateDTOCollection;
use Iamvar\Rates\RateLoader\Service\RateSource\CoindeskRateSource;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

beforeEach(function () {
    $this->client = new MockHttpClient();
    $this->coindesk = new CoindeskRateSource($this->client);
});

test('get rates', function () {
    $response = /** @lang JSON */
        <<<RESPONSE
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
    $this->client->setResponseFactory([
        new MockResponse($response),
    ]);

    $rate1 = new RateDTO('BTC', 'USD', '11302.8875', new \DateTimeImmutable('2020-09-03'));
    $rate2 = new RateDTO('BTC', 'USD', '10292.5983', new \DateTimeImmutable('2020-09-04'));
    $expected = new RateDTOCollection($rate1, $rate2);
    expect($this->coindesk->getRates())->toEqual($expected);
});

test('invalid response', function () {
    $this->client->setResponseFactory([
        new MockResponse('{}'),
    ]);

    $this->coindesk->getRates();
})->throws(\ValueError::class, 'Expect bpi section to be json object');