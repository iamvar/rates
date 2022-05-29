<?php
declare(strict_types=1);

namespace Iamvar\Rates\RateLoader;

use Iamvar\Rates\RateLoader\DTO\RateDTOCollection;

interface RateSourceInterface {
    public static function getName(): string;
    public function getRates(): RateDTOCollection;
}
