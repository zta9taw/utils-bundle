<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Repository;

use Doctrine\Common\Collections\Selectable;
use Doctrine\Persistence\ObjectRepository;
use Zta9taw\Bundle\UtilsBundle\Entity\EntityInterface;
use Zta9taw\Bundle\UtilsBundle\Repository\Criteria\CriteriaInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;

interface EntityRepositoryInterface extends ObjectRepository, Selectable, ServiceEntityRepositoryInterface
{
    public function findByCriteria(CriteriaInterface $criteria): iterable;

    public function findOneByCriteria(CriteriaInterface $criteria): ?EntityInterface;

    public function findCachedByCriteria(CriteriaInterface $criteria): iterable;

    public function countByCriteria(CriteriaInterface $criteria): int;

    public function save(EntityInterface $entity, bool $flush = true): void;

    public function delete(EntityInterface $entity, bool $flush = false): void;

    public function flush(): void;
}
