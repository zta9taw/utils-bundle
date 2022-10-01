<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Entity;

interface PersonInterface
{
    public function getFirstName(): string;

    public function getLastName(): string;
}
