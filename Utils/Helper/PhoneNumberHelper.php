<?php

declare(strict_types=1);

namespace App\Utils\Helper;

/**
 * Class PhoneNumberHelper
 */
class PhoneNumberHelper
{
    /**
     * Check if the given phone number is a valid French phone number.
     *
     * @param string $phoneNumber
     *
     * @return bool
     */
    public static function isValid(string $phoneNumber): bool
    {
        return (bool) preg_match('/^\+33\s*[1-9](?:[\s.-]*\d{2}){4}$/', $phoneNumber);
    }
}
