<?php
declare(strict_types=1);

namespace Iamvar\Rates\Service\RateLoader;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Iamvar\Rates\Entity\Source;
use Iamvar\Rates\EntityManager\RateEntityManager;

/**
 * gets data from rates repositories like ecb and saves it in the database
 */
class RateService
{
    private RateRepositoriesCollection $rateRepositoriesCollection;
    private RateEntityManager $rateEntityManager;
    private EntityManagerInterface $em;
    
    public function __construct(
        RateRepositoriesCollection $rateRepositoriesCollection,
        RateEntityManager $rateEntityManager,
        EntityManagerInterface $em
    ) {
        $this->rateRepositoriesCollection = $rateRepositoriesCollection;
        $this->rateEntityManager = $rateEntityManager;
        $this->em = $em;
    }
    
    public function saveRates(): void
    {
        foreach ($this->rateRepositoriesCollection->getSources() as $source) {
            $this->saveRatesFromSource($source);
        }
    }

    public function saveRatesFromSource(string $sourceName): void
    {
        $rates = $this->rateRepositoriesCollection->getRepository($sourceName)->getRates();
        /** @var ObjectRepository $sourceEntityManager */
        $sourceEntityManager = $this->em->getRepository(Source::class);
        /** @var Source $sourceEntity */
        $sourceEntity = $sourceEntityManager->find($sourceName);

        foreach ($rates as $rate) {
            $rate->setSource($sourceName);
            $rate->setWeight($sourceEntity->getDefaultWeight());
        }

        $this->rateEntityManager->save($rates);
    }
}