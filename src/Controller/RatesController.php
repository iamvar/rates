<?php

declare(strict_types=1);

namespace Iamvar\Rates\Controller;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Iamvar\Rates\Entity\Rate;
use Iamvar\Rates\Repository\ActualRateRepository;
use Iamvar\Rates\Service\RateLoader\RateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Rest\Route("/api")
 */
final class RatesController extends AbstractController
{
    private EntityManagerInterface $em;
    private ActualRateRepository $actualRateRepository;
    private SerializerInterface $serializer;
    private RateService $rateLoaderService;

    public function __construct(
        EntityManagerInterface $em,
        ActualRateRepository $actualRateRepository,
        SerializerInterface $serializer,
        RateService $rateLoaderService
    ) {
        $this->em = $em;
        $this->actualRateRepository = $actualRateRepository;
        $this->serializer = $serializer;
        $this->rateLoaderService = $rateLoaderService;
    }

    /**
     * @throws BadRequestHttpException
     *
     * @Rest\Post("/create", name="createRate")
     */
    public function createAction(Request $request): JsonResponse
    {
        $message = $request->request->get('message');
        if (empty($message)) {
            throw new BadRequestHttpException('message cannot be empty');
        }
//        $post = new Rate();
//        $post->setMessage($message);
//        $this->em->persist($post);
//        $this->em->flush();
//        $data = $this->serializer->serialize($post, JsonEncoder::FORMAT);
        $data = [];
        return new JsonResponse($data, Response::HTTP_CREATED, [], true);
    }

    /**
     * @Rest\Get("/rates", name="findAllRates")
     */
    public function findAllAction(): JsonResponse
    {
        $rates = $this->em->getRepository(Rate::class)->findBy(
            [],
            [Rate::PROP_FROM_DATE => 'DESC', Rate::PROP_SOURCE => 'DESC', Rate::PROP_WEIGHT => 'DESC']
        );
        $data = $this->serializer->serialize($rates, JsonEncoder::FORMAT);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Rest\Get("/latest")
     */
    public function findLatestAction(): JsonResponse
    {
        $rates = $this->actualRateRepository->getActualRates();
        $data = $this->serializer->serialize($rates, JsonEncoder::FORMAT);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Rest\Get("/retrieve")
     */
    public function retrieveRatesAction(): JsonResponse
    {
        $this->rateLoaderService->saveRates();

        return new JsonResponse();
    }
}