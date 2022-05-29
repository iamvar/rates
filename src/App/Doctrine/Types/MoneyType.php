<?php

namespace Iamvar\Rates\App\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DecimalType;

final class MoneyType extends DecimalType
{
    public const KEY = 'money';

    public function getName(): string
    {
        return self::KEY;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['precision'] = 25;
        $column['scale'] = 10;
        return $platform->getDecimalTypeDeclarationSQL($column);
    }
}