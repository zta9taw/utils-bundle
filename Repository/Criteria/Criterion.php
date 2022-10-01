<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Repository\Criteria;

class Criterion
{
    public function __construct(public readonly string $field, public readonly mixed $value)
    {
    }
}
