<?php
declare(strict_types=1);

namespace Iamvar\Rates\Rate\Entity;

use DateTime;

/**
 * DateTime that can be converted to string without explicit call ->format()
 */
class DateTimeStringable extends DateTime
{
    public function __toString(): string
    {
        return $this->format(DATE_ATOM);
    }
}
