<?php
declare(strict_types=1);

namespace Iamvar\Rates\App\Doctrine\Types;

use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateType;

/**
 * This type was created as doctrine cannot use composite primary key with date object
 * see https://stackoverflow.com/questions/15080573/doctrine-2-orm-datetime-field-in-identifier
 */
class StringDateType extends DateType
{
    public const KEY = 'string_date';

    public function getName(): string
    {
        return self::KEY;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): DateTimeInterface
    {
        $dateTime = parent::convertToPHPValue($value, $platform);

        if (!$dateTime) {
            return $dateTime;
        }

        $stringDate = new class extends \DateTime {
            public function __toString(): string
            {
                return $this->format('Uu');
            }
        };

        return $stringDate::createFromInterface($dateTime);
    }
}
