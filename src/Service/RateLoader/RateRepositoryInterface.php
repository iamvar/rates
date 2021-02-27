<?php
declare(strict_types=1);

namespace Iamvar\Rates\Service\RateLoader;

use Iamvar\Rates\Service\RateLoader\DTO\RatesDTO;

interface RateRepositoryInterface {
    public function getRates(): RatesDTO;
}
