<?php
declare(strict_types=1);

namespace Iamvar\Rates\EntityManager;


use Doctrine\ORM\Decorator\EntityManagerDecorator;
use Iamvar\Rates\Entity\Rate;
use Iamvar\Rates\Entity\Rates;

class RateEntityManager extends EntityManagerDecorator
{
    public function save(Rates $rates): void
    {
        foreach ($rates as $rate) {
            if (!$this->find(Rate::class, $rate->getPrimaryKeyArray())) {
                $this->wrapped->persist($rate);
            }
        }

        $this->wrapped->flush();
    }
}