<?php
declare(strict_types=1);

namespace Iamvar\Rates\EntityManager;


use Doctrine\ORM\Decorator\EntityManagerDecorator;
use Iamvar\Rates\Entity\Rate;

class RateEntityManager extends EntityManagerDecorator
{
    public function save(Rate ...$rates): void
    {
        foreach ($rates as $rate) {
            if (!$this->find(Rate::class, $rate->getPrimaryKeyArray())) {
                $this->wrapped->persist($rate);
            }
        }

        $this->wrapped->flush();
    }
}