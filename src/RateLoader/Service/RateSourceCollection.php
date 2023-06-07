<?php
declare(strict_types=1);

namespace Iamvar\Rates\RateLoader\Service;

use Iamvar\Rates\RateLoader\RateSourceInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

class RateSourceCollection
{
    public function __construct(
        private readonly ServiceLocator $locator
    ) {
    }

    /**
     * @return RateSourceInterface[]
     */
    public function getSources(): iterable
    {
        foreach (array_keys($this->locator->getProvidedServices()) as $name) {
            yield $this->locator->get($name);
        }
    }

    public function get(string $name): RateSourceInterface
    {
        if ($this->locator->has($name)) {
            return $this->locator->get($name);
        }

        throw new \RuntimeException("'{$name}' rate source is not configured");
    }
}
