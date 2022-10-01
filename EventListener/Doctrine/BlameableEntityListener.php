<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\EventListener\Doctrine;

use Zta9taw\Bundle\UtilsBundle\Entity\BlameableEntityInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;

class BlameableEntityListener
{
    public function __construct(private readonly Security $security)
    {
    }

    public function prePersist(BlameableEntityInterface $entity): void
    {
        $user = $this->security->getUser();
        if (!$user instanceof UserInterface) {
            return;
        }

        $entity->setCreatedBy($user);
    }

    public function preUpdate(BlameableEntityInterface $entity): void
    {
        $user = $this->security->getUser();
        if (!$user instanceof UserInterface) {
            return;
        }

        $entity->setUpdatedBy($user);
    }
}
