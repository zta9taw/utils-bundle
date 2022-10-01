<?php

declare(strict_types=1);

namespace App\Utils\Helper;

use DateTimeInterface;

/**
 * Class CompareHelper
 */
class CompareHelper
{
    /**
     * @param DateTimeInterface $subject
     * @param DateTimeInterface $start
     * @param DateTimeInterface $end
     *
     * @return bool
     */
    public static function inRange(DateTimeInterface $subject, DateTimeInterface $start, DateTimeInterface $end): bool
    {
        return $subject >= $start && $subject <= $end;
    }
}
