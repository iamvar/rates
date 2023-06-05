<?php
declare(strict_types=1);

namespace Iamvar\Rates\RateLoader\Service;

use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;

/**
 * Gets data from rates repositories like ecb and saves it in the database
 */
class RateLoader
{
    public function __construct(
        private RateSourceCollection $rateSourceCollection,
        private readonly LoggerInterface $logger,
        private Connection $connection,
    ) {
    }

    public function saveRates(): void
    {
        foreach ($this->rateSourceCollection->getSources() as $source) {
            try {
                $ratesCollection = $source->getRates();
            } catch (\Throwable $e) {
                $this->logger->error($e->getMessage());
                continue;
            }

            $rows = [];
            //will do bulk insert for performance purposes
            foreach ($ratesCollection as $rateDTO) {
                $rows[] = [
                    'source' => $source::getName(),
                    'base_currency' => $rateDTO->getBaseCurrency(),
                    'quote_currency' => $rateDTO->getQuoteCurrency(),
                    'rate' => $rateDTO->getRate(),
                    'from_date' => $rateDTO->getDate(),
                    'weight' => $source->getDefaultWeight()
                ];
            }

            //todo: update sql for bulk insert
            $this->connection->createQueryBuilder()->executeQuery($rows);
        }
    }
}
