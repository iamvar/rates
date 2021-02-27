<?php
declare(strict_types=1);

namespace Iamvar\Rates\Service\RateLoader;

use DateTimeImmutable;
use Iamvar\Rates\Service\RateLoader\DTO\RateDTO;
use Iamvar\Rates\Service\RateLoader\DTO\RatesDTO;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Parses content from ecb.europa.eu xml
 * initial xml looks like
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
 */
class EcbRateRepository implements RateRepositoryInterface
{
    private const DEFAULT_URL = 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';
    private const BASE_CURRENCY = 'EUR';

    public function __construct(
        private ContentObtainerInterface $contentObtainer,
        private string $url = self::DEFAULT_URL,
    ) {
    }

    public function getRates(): RatesDTO
    {
        $xml = $this->contentObtainer->getContent($this->url);

        $crawler = new Crawler($xml);

        $cube = $crawler->filter("gesmes|Envelope default|Cube default|Cube");
        $date = new DateTimeImmutable($cube->attr('time'));

        $ratesArray = $cube->children()->each(fn($node, $i) => new RateDTO(
            self::BASE_CURRENCY,
            $node->attr('currency'),
            (float)$node->attr('rate'),
            $date
        ));

        return new RatesDTO(...$ratesArray);
    }
}
