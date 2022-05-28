<?php
declare(strict_types=1);

namespace Iamvar\Rates\RateLoader\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Iamvar\Rates\Entity\Rate;
use Iamvar\Rates\Entity\Source;
use Iamvar\Rates\EntityManager\RateEntityManager;

/**
 * gets data from rates repositories like ecb and saves it in the database
 */
class RateLoader
{
    public function __construct(
        private RateSourceCollection   $rateSourceCollection,
//        private RateEntityManager $rateEntityManager,
        private EntityManagerInterface $em,
    )
    {
    }

    public function saveRates(): void
    {
        foreach ($this->rateSourceCollection->getSources() as $source) {
            /** @var ObjectRepository $sourceEntityManager */
//            $sourceEntityManager = $this->em->getRepository(Source::class);
//            /** @var Source $source */
//            $source = $sourceEntityManager->find($sourceName);

            $rates = [];
            foreach ($source->getRates() as $rateDTO) {
                $rates[] = new Rate(
                    $source::getName(),
                    $rateDTO->getBaseCurrency(),
                    $rateDTO->getQuoteCurrency(),
                    $rateDTO->getRate(),
                    $rateDTO->getDate(),
                    $source->getDefaultWeight()
                );
            }
            dd($rates);
//        $this->rateEntityManager->save(...$rates);
        }
    }
}
