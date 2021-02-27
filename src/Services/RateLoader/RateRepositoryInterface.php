<?php
declare(strict_types=1);

namespace Iamvar\Rates\Services\RateLoader;

use Iamvar\Rates\Services\RateLoader\DTO\RatesDTO;

interface RateRepositoryInterface {
    public function getRates(): RatesDTO;
}
