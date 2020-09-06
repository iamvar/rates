<?php
declare(strict_types=1);

namespace Iamvar\Rates\Service\RateLoader;

use Iamvar\Rates\Service\RateLoader\Exception\UnknownSourceException;

class RateRepositoriesCollection
{
    private $repositories;

    public function __construct(array $repositories)
    {
        foreach ($repositories as $source => $repository) {
            $this->repositories[$source] = $repository;
        }
    }

    public function addRepository(string $source, RateRepositoryInterface $rateRepository): void
    {
        $this->repositories[$source] = $rateRepository;
    }

    /**
     * @return array|string[]
     */
    public function getSources(): array
    {
        return array_keys($this->repositories);
    }

    public function getRepository(string $source): RateRepositoryInterface
    {
        if (isset($this->repositories[$source])) {
            return $this->repositories[$source];
        }

        throw new UnknownSourceException("application is not configured to use '{$source}' rate repository");
    }
}