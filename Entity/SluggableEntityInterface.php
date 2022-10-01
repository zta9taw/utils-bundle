<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Entity;

interface SluggableEntityInterface
{
    public function getPlainValue(): string;

    public function setSluggedValue(string $slug): static;
}
