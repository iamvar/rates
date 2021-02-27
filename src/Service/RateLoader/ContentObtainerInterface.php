<?php
declare(strict_types=1);

namespace Iamvar\Rates\Service\RateLoader;

interface ContentObtainerInterface
{
    public function getContent(string $url): string;
}
