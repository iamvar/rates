<?php
declare(strict_types=1);

namespace Iamvar\Rates\Service\RateLoader;

use Iamvar\Rates\Entity\Rates;

interface RateRepositoryInterface {
    public function getRates(): Rates;
}
