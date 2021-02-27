<?php
declare(strict_types=1);

namespace Iamvar\Rates\Tests\Services\RateLoader;

use Iamvar\Rates\Services\RateLoader\DTO\RateDTO;
use Iamvar\Rates\Services\RateLoader\DTO\RatesDTO;
use Iamvar\Rates\Services\RateLoader\EcbRateRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class EcbRateRepositoryTest extends TestCase
{
    public function testGettingRates(): void
    {
        $response = <<<RESPONSE
<?xml version="1.0" encoding="UTF-8"?>
  <gesmes:Envelope xmlns:gesmes="http://www.gesmes.org/xml/2002-08-01" xmlns="http://www.ecb.int/vocabulary/2002-08-01/eurofxref">
    <gesmes:subject>Reference rates</gesmes:subject>
    <gesmes:Sender>
    <gesmes:name>European Central Bank</gesmes:name>
  </gesmes:Sender>
  <Cube>
    <Cube time='2020-09-04'>
      <Cube currency='USD' rate='1.1842'/>
      <Cube currency='JPY' rate='125.79'/>
    </Cube>
  </Cube>
</gesmes:Envelope>
RESPONSE;
        $client = new MockHttpClient([
            new MockResponse($response),
        ]);

        $repository = new EcbRateRepository($client);
        $rate1 = new RateDTO('EUR', 'USD', 1.1842, new \DateTimeImmutable('2020-09-04'));
        $rate2 = new RateDTO('EUR', 'JPY', 125.79, new \DateTimeImmutable('2020-09-04'));
        $expected = new RatesDTO($rate1, $rate2);
        $this->assertEquals($expected, $repository->getRates());
    }
}
