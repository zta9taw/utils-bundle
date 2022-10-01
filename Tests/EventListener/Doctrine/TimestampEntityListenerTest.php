<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Tests\EventListener\Doctrine;

use PHPUnit\Framework\TestCase;
use Zta9taw\Bundle\UtilsBundle\Entity\TimestampEntityInterface;
use Zta9taw\Bundle\UtilsBundle\EventListener\Doctrine\TimestampEntityListener;

class TimestampEntityListenerTest extends TestCase
{
    public function testPrePersist(): void
    {
        $entity = $this->createMock(TimestampEntityInterface::class);
        $entity
            ->expects($this->once())
            ->method('setCreatedAt')
        ;
        $timestampEntityListener = new TimestampEntityListener();
        $timestampEntityListener->prePersist($entity);
    }

    public function testPreUpdate(): void
    {
        $entity = $this->createMock(TimestampEntityInterface::class);
        $entity
            ->expects($this->once())
            ->method('setUpdatedAt')
        ;
        $timestampEntityListener = new TimestampEntityListener();
        $timestampEntityListener->preUpdate($entity);
    }
}
