<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\EventListener\Doctrine;

use Zta9taw\Bundle\UtilsBundle\Entity\SluggableEntityInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class SluggableEntityListener
{
    public function __construct(private readonly SluggerInterface $slugger)
    {
    }

    public function prePersist(SluggableEntityInterface $entity): void
    {
        if (empty($entity->getPlainValue())) {
            return;
        }

        $entity->setSluggedValue(
            strtolower((string) $this->slugger->slug($entity->getPlainValue()))
        );
    }

    public function preUpdate(SluggableEntityInterface $entity): void
    {
        if (empty($entity->getPlainValue())) {
            return;
        }

        $entity->setSluggedValue(
            strtolower((string) $this->slugger->slug($entity->getPlainValue()))
        );
    }
}
