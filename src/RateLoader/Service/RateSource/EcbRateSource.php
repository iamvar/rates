<?php
declare(strict_types=1);

namespace Iamvar\Rates\RateLoader\Service\RateSource;

use Iamvar\Rates\RateLoader\DTO\RateDTO;
use Iamvar\Rates\RateLoader\DTO\RateDTOCollection;
use Iamvar\Rates\RateLoader\RateSourceInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Parses content from ecb.europa.eu xml
 * initial xml looks like
 * <?xml version="1.0" encoding="UTF-8"?>
 * <gesmes:Envelope xmlns:gesmes="http://www.gesmes.org/xml/2002-08-01" xmlns="http://www.ecb.int/vocabulary/2002-08-01/eurofxref">
 *   <gesmes:subject>Reference rates</gesmes:subject>
 *   <gesmes:Sender>
 *     <gesmes:name>European Central Bank</gesmes:name>
 *   </gesmes:Sender>
 * <Cube>
 *   <Cube time='2020-09-04'>
 *     <Cube currency='USD' rate='1.1842'/>
 *     <Cube currency='JPY' rate='125.79'/>
 *   </Cube>
 * </Cube>
 * </gesmes:Envelope>
 */
class EcbRateSource implements RateSourceInterface
{
    private const DEFAULT_URL = 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';
    private const BASE_CURRENCY = 'EUR';

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $url = self::DEFAULT_URL,
    ) {
    }

    public static function getName(): string
    {
        return 'ecb';
    }

    public function getRates(): RateDTOCollection
    {
        $xml = $this->client->request('GET', $this->url)->getContent();

        $crawler = new Crawler($xml);

        $cube = $crawler->filter("gesmes|Envelope default|Cube default|Cube");
        $date = new \DateTimeImmutable($cube->attr('time'));

        $rates = $cube->children()->each(fn($node, $i) => new RateDTO(
            self::BASE_CURRENCY,
            $node->attr('currency'),
            (string)$node->attr('rate'),
            $date
        ));

        return new RateDTOCollection(...$rates);
    }
}
