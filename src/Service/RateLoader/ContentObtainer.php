<?php
declare(strict_types=1);

namespace Iamvar\Rates\Service\RateLoader;

use GuzzleHttp\Client;
use Iamvar\Rates\Service\RateLoader\Exception\ObtainContentException;
use Symfony\Component\HttpFoundation\Response;

class ContentObtainer implements ContentObtainerInterface
{
    private Client $client;

    public function __construct() {
        $this->client = new Client();
    }

    public function getContent(string $url): string
    {
        $response = $this->client->request('GET', $url);

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new ObtainContentException("Error while obtaingn content from {$url}");
        }

        return $response->getBody()->getContents();
    }
}