<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Utils\Traits;

use Doctrine\ORM\Mapping\Column;

trait ArchivedEntityTrait
{
    #[Column(type: 'boolean', options: ['default' => false])]
    protected bool $archived = false;

    public function isArchived(): bool
    {
        return $this->archived;
    }
    public function setArchived(bool $archived): static
    {
        $this->archived = $archived;

        return $this;
    }
}
