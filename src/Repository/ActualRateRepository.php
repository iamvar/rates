<?php
declare(strict_types=1);

namespace Iamvar\Rates\Repository;


use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Iamvar\Rates\Entity\DTO\ActualRateDTO;
use Iamvar\Rates\Entity\Rate;

class ActualRateRepository
{

    public function __construct(private EntityManagerInterface $em)
    {
    }

    /**
     * Will take latest rates for the last 2 days, considering weight
     *
     * @return ActualRateDTO[]
     */
    public function getActualRates(): array
    {
        $date = (new DateTime('now - 3 days'))->setTime(0,0,0,0);

        $qb = $this->em->createQueryBuilder()
            ->select([
                'r.' . Rate::PROP_BASE_CURRENCY,
                'r.' . Rate::PROP_QUOTE_CURRENCY,
                'r.' . Rate::PROP_RATE,
            ])
            ->from(Rate::class, 'r')
            ->where('r.' . Rate::PROP_FROM_DATE . '>= :date')
            ->setParameter('date', $date)
            ->addOrderBy('r.' . Rate::PROP_FROM_DATE)
            ->addOrderBy('r.' . Rate::PROP_WEIGHT)
        ;

        $rows = $qb->getQuery()->execute();

        $result = [];
        foreach ($rows as $row) {
            //will override rates with latest ones as order is by date
            $key = $row[Rate::PROP_BASE_CURRENCY].$row[Rate::PROP_QUOTE_CURRENCY];
            $result[$key] = new ActualRateDTO(
                $row[Rate::PROP_BASE_CURRENCY],
                $row[Rate::PROP_QUOTE_CURRENCY],
                (string)$row[Rate::PROP_RATE]
            );
        }

        return array_values($result);
    }
}
