<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Entity;

interface ArchivedEntityInterface
{
    public function isArchived(): bool;

    public function setArchived(bool $archived): static;
}
