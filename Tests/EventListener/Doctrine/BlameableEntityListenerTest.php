<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Tests\EventListener\Doctrine;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Zta9taw\Bundle\UtilsBundle\Entity\BlameableEntityInterface;
use Zta9taw\Bundle\UtilsBundle\EventListener\Doctrine\BlameableEntityListener;

class BlameableEntityListenerTest extends TestCase
{
    public function testPrePersistWithoutUser(): void
    {
        $security = $this->createMock(Security::class);
        $security
            ->expects($this->once())
            ->method('getUser')
            ->willReturn(null)
        ;
        $entity = $this->createMock(BlameableEntityInterface::class);
        $entity
            ->expects($this->never())
            ->method('setCreatedBy')
        ;
        $blameableEntityListener = new BlameableEntityListener($security);
        $blameableEntityListener->prePersist($entity);
    }

    public function testPrePersistWithUser(): void
    {
        $security = $this->createMock(Security::class);
        $user = $this->createMock(UserInterface::class);
        $security
            ->expects($this->once())
            ->method('getUser')
            ->willReturn($user)
        ;
        $entity = $this->createMock(BlameableEntityInterface::class);
        $entity
            ->expects($this->once())
            ->method('setCreatedBy')
            ->with($user)
            ->willReturnSelf()
        ;
        $blameableEntityListener = new BlameableEntityListener($security);
        $blameableEntityListener->prePersist($entity);
    }

    public function testPreUpdateWithoutUser(): void
    {
        $security = $this->createMock(Security::class);
        $security
            ->expects($this->once())
            ->method('getUser')
            ->willReturn(null)
        ;
        $entity = $this->createMock(BlameableEntityInterface::class);
        $entity
            ->expects($this->never())
            ->method('setUpdatedBy')
        ;
        $blameableEntityListener = new BlameableEntityListener($security);
        $blameableEntityListener->preUpdate($entity);
    }

    public function testPreUpdateWithUser(): void
    {
        $security = $this->createMock(Security::class);
        $user = $this->createMock(UserInterface::class);
        $security
            ->expects($this->once())
            ->method('getUser')
            ->willReturn($user)
        ;
        $entity = $this->createMock(BlameableEntityInterface::class);
        $entity
            ->expects($this->once())
            ->method('setUpdatedBy')
            ->with($user)
            ->willReturnSelf()
        ;
        $blameableEntityListener = new BlameableEntityListener($security);
        $blameableEntityListener->preUpdate($entity);
    }
}
