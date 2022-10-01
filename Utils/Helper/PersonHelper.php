<?php

declare(strict_types=1);

namespace App\Utils\Helper;

use App\Entity\PersonInterface;

/**
 * Class PersonHelper
 */
class PersonHelper
{
    const GENDER_MISTER = 'MISTER';
    const GENDER_MADAM = 'MADAM';

    /**
     * @param PersonInterface $person
     *
     * @return string
     */
    public static function getFullName(PersonInterface $person): string
    {
        return sprintf('%s %s', $person->getFirstName(), $person->getLastName());
    }
}
