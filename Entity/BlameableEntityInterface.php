<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

interface BlameableEntityInterface
{
    public function getCreatedBy(): ?UserInterface;

    public function setCreatedBy(UserInterface $user): static;

    public function getUpdatedBy(): ?UserInterface;

    public function setUpdatedBy(?UserInterface $user): static;
}
