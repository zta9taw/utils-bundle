<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\EventListener\Doctrine;

use Zta9taw\Bundle\UtilsBundle\Entity\TimestampEntityInterface;
use DateTime;

class TimestampEntityListener
{
    public function prePersist(TimestampEntityInterface $entity): void
    {
        $entity->setCreatedAt(new DateTime());
    }

    public function preUpdate(TimestampEntityInterface $entity): void
    {
        $entity->setUpdatedAt(new DateTime());
    }
}
