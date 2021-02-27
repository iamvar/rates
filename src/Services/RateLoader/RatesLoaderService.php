<?php
declare(strict_types=1);

namespace Iamvar\Rates\Services\RateLoader;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Iamvar\Rates\Entity\Rate;
use Iamvar\Rates\Entity\Source;
use Iamvar\Rates\EntityManager\RateEntityManager;

/**
 * gets data from rates repositories like ecb and saves it in the database
 */
class RatesLoaderService
{
    public function __construct(
        private RateRepositoriesCollection $rateRepositoriesCollection,
        private RateEntityManager $rateEntityManager,
        private EntityManagerInterface $em,
    ) {
    }
    
    public function saveRates(): void
    {
        foreach ($this->rateRepositoriesCollection->getSources() as $source) {
            $this->saveRatesFromSource($source);
        }
    }

    public function saveRatesFromSource(string $sourceName): void
    {
        $ratesDTO = $this->rateRepositoriesCollection->getRepository($sourceName)->getRates();
        /** @var ObjectRepository $sourceEntityManager */
        $sourceEntityManager = $this->em->getRepository(Source::class);
        /** @var Source $source */
        $source = $sourceEntityManager->find($sourceName);

        $rates = [];
        foreach ($ratesDTO as $rateDTO) {
            $rates[] = new Rate(
                $sourceName,
                $rateDTO->getBaseCurrency(),
                $rateDTO->getQuoteCurrency(),
                $rateDTO->getRate(),
                $rateDTO->getDate(),
                $source->getDefaultWeight()
            );
        }

        $this->rateEntityManager->save(...$rates);
    }
}
