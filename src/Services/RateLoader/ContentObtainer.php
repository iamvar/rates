<?php
declare(strict_types=1);

namespace Iamvar\Rates\Services\RateLoader;

use Iamvar\Rates\Services\RateLoader\Exception\ObtainContentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ContentObtainer implements ContentObtainerInterface
{
    public function __construct(private HttpClientInterface $client) {
    }

    public function getContent(string $url): string
    {
        $response = $this->client->request('GET', $url);

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new ObtainContentException("Error while obtaining content from {$url}");
        }

        return $response->getContent();
    }
}
