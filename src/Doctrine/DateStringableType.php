<?php
declare(strict_types=1);

namespace Iamvar\Rates\Doctrine;

use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateType;
use Iamvar\Rates\Entity\DateTimeStringable;

/**
 * This type was created as doctrine cannot use composite primary key with date object
 * see https://stackoverflow.com/questions/15080573/doctrine-2-orm-datetime-field-in-identifier
 */
class DateStringableType extends DateType
{
    public const STRINGABLE_DATE = 'stringable_date';

    public function convertToPHPValue($value, AbstractPlatform $platform): DateTimeInterface
    {
        $dateTime = parent::convertToPHPValue($value, $platform);

        if ( ! $dateTime) {
            return $dateTime;
        }

        return new DateTimeStringable($dateTime->format(DATE_ATOM));
    }

    public function getName(): string
    {
        return self::STRINGABLE_DATE;
    }
}