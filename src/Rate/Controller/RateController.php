<?php
declare(strict_types=1);

namespace Iamvar\Rates\Rate\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Iamvar\Rates\Rate\Entity\Rate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class RateController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
    )
    {
    }

    #[Route('/api/rates', methods: ['GET'])]
    public function findAllAction(): JsonResponse
    {
        $rates = $this->em->getRepository(Rate::class)->findBy(
            [],
            ['from_date' => 'DESC', 'source' => 'DESC', 'weight' => 'DESC']
        );
        return $this->json($rates);
    }
}
