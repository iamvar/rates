<?php
declare(strict_types=1);

namespace Iamvar\Rates\Tests\RateLoader\Service\RateSource;

use Iamvar\Rates\RateLoader\DTO\RateDTO;
use Iamvar\Rates\RateLoader\DTO\RateDTOCollection;
use Iamvar\Rates\RateLoader\Service\RateSource\EcbRateSource;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class EcbRateSourceTest extends TestCase
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

        $repository = new EcbRateSource($client);
        $rate1 = new RateDTO('EUR', 'USD', '1.1842', new \DateTimeImmutable('2020-09-04'));
        $rate2 = new RateDTO('EUR', 'JPY', '125.79', new \DateTimeImmutable('2020-09-04'));
        $expected = new RateDTOCollection($rate1, $rate2);
        $this->assertEquals($expected, $repository->getRates());
    }

    public function testInvalidResponse(): void
    {
        $response = <<<RESPONSE
<?xml version="1.0" encoding="UTF-8"?>
<error:Envelope xmlns:gesmes="http://www.gesmes.org/xml/2002-08-01" xmlns="http://www.ecb.int/vocabulary/2002-08-01/eurofxref">
</error:Envelope>
RESPONSE;
        $client = new MockHttpClient([
            new MockResponse($response),
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The current node list is empty.');
        $repository = new EcbRateSource($client);
        $this->assertEquals('', $repository->getRates());
    }
}
