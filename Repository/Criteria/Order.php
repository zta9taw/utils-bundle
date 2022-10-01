<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Repository\Criteria;

class Order
{
    const DESC = 'DESC';
    const ASC = 'ASC';

    public function __construct(public readonly string $field, public readonly string $direction = self::ASC)
    {
    }
}
