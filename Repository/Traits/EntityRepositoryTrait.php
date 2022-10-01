<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Repository\Traits;

use Zta9taw\Bundle\UtilsBundle\Repository\Criteria\CriteriaInterface;
use Zta9taw\Bundle\UtilsBundle\Repository\Criteria\Criterion;
use Zta9taw\Bundle\UtilsBundle\Repository\Criteria\Order;
use Zta9taw\Bundle\UtilsBundle\Repository\Criteria\PaginatedCriteriaInterface;
use Zta9taw\Bundle\UtilsBundle\Entity\EntityInterface;
use Doctrine\ORM\QueryBuilder;
use InvalidArgumentException;
use LogicException;

trait EntityRepositoryTrait
{
    public function findByCriteria(CriteriaInterface $criteria): iterable
    {
        $queryBuilder = $this->getQueryBuilderByCriteria($criteria);

        return $queryBuilder->getQuery()->getResult();
    }

    public function findOneByCriteria(CriteriaInterface $criteria): ?EntityInterface
    {
        $queryBuilder = $this->getQueryBuilderByCriteria($criteria);

        $result = $queryBuilder->getQuery()->setMaxResults(1)->getResult();

        return $result[0] ?? null;
    }

    public function findCachedByCriteria(CriteriaInterface $criteria): iterable
    {
        $queryBuilder = $this->getQueryBuilderByCriteria($criteria);
        if ($criteria instanceof PaginatedCriteriaInterface) {
            $queryBuilder
                ->setMaxResults($criteria->getLimit())
                ->setFirstResult(0 < $criteria->getPage() ? $criteria->getPage() - 1 : $criteria->getPage())
            ;
        }

        $query = $queryBuilder->getQuery();
        $query->enableResultCache(864000);

        return $query->getResult();
    }

    public function countByCriteria(CriteriaInterface $criteria): int
    {
        $queryBuilder = $this->getQueryBuilderByCriteria($criteria);
        $queryBuilder->select(sprintf('COUNT(%s)', static::ALIAS));

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    public function save(EntityInterface $entity, bool $flush = true): void
    {
        if (!$this->isSupportedObject($entity)) {
            $this->throwObjectNotSupportedException($entity);
        }

        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->flush();
        }
    }

    public function delete(EntityInterface $entity, bool $flush = false): void
    {
        if (!$this->isSupportedObject($entity)) {
            $this->throwObjectNotSupportedException($entity);
        }

        $this->getEntityManager()->remove($entity);
        if ($flush) {
            $this->flush();
        }
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    protected function getQueryBuilderByCriteria(CriteriaInterface $criteria): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder(static::ALIAS);

        /** @var Criterion $criterion */
        foreach ($criteria->getCriteria(false) as $criterion) {
            $addCriterionMethod = sprintf('add%sCriterion', ucfirst($criterion->field));
            if (!is_callable([$this, $addCriterionMethod])) {
                throw new LogicException(sprintf(
                    'The method %s must be defined in %s class',
                    $addCriterionMethod,
                    static::class
                ));
            }

            $this->{$addCriterionMethod}($queryBuilder, $criterion->value);
        }

        /** @var Order $order */
        foreach ($criteria->getOrders() as $order) {
            $addOrderMethod = sprintf('add%sOrder', ucfirst($order->field));
            if (!is_callable([$this, $addOrderMethod])) {
                throw new LogicException(sprintf(
                    'The method %s must be defined in %s class',
                    $addOrderMethod,
                    static::class
                ));
            }

            $this->{$addOrderMethod}($queryBuilder, $order->direction);
        }

        return $queryBuilder;
    }

    private function isSupportedObject(EntityInterface $entity): bool
    {
        return $entity instanceof $this->_entityName;
    }

    private function throwObjectNotSupportedException(EntityInterface $entity): void
    {
        throw new InvalidArgumentException(sprintf(
            'Unsupported object type, it must be an instance of (%s), %s given',
            $this->_entityName,
            get_class($entity)
        ));
    }
}
