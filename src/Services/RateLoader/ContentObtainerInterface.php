<?php
declare(strict_types=1);

namespace Iamvar\Rates\Services\RateLoader;

interface ContentObtainerInterface
{
    public function getContent(string $url): string;
}
