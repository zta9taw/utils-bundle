<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Tests\EventListener\Doctrine;

use PHPUnit\Framework\TestCase;
use Symfony\Component\String\Slugger\SluggerInterface;
use Zta9taw\Bundle\UtilsBundle\Entity\SluggableEntityInterface;
use Zta9taw\Bundle\UtilsBundle\EventListener\Doctrine\SluggableEntityListener;

class SluggableEntityListenerTest extends TestCase
{
    public function testPrePersistWithEmptyValue(): void
    {
        $slugger = $this->createMock(SluggerInterface::class);
        $slugger
            ->expects($this->never())
            ->method('slug')
        ;
        $entity = $this->createMock(SluggableEntityInterface::class);
        $entity
            ->expects($this->once())
            ->method('getPlainValue')
            ->willReturn('')
        ;
        $entity
            ->expects($this->never())
            ->method('setSluggedValue')
        ;
        $sluggableEntityListener = new SluggableEntityListener($slugger);
        $sluggableEntityListener->prePersist($entity);
    }

    public function testPreUpdateWithEmptyValue(): void
    {
        $slugger = $this->createMock(SluggerInterface::class);
        $slugger
            ->expects($this->never())
            ->method('slug')
        ;
        $entity = $this->createMock(SluggableEntityInterface::class);
        $entity
            ->expects($this->once())
            ->method('getPlainValue')
            ->willReturn('')
        ;
        $entity
            ->expects($this->never())
            ->method('setSluggedValue')
        ;
        $sluggableEntityListener = new SluggableEntityListener($slugger);
        $sluggableEntityListener->preUpdate($entity);
    }
}
