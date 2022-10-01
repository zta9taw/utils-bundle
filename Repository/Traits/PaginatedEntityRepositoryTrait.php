<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Repository\Traits;

use Zta9taw\Bundle\UtilsBundle\Repository\Criteria\PaginatedCriteriaInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use LogicException;

trait PaginatedEntityRepositoryTrait
{
    public function findPaginatedByCriteria(PaginatedCriteriaInterface $criteria): PaginationInterface
    {
        if (!property_exists($this, 'paginator')
            || !$this->paginator instanceof PaginatorInterface) {
            throw new LogicException(sprintf(
                'You repository class [%s] must have a paginator [instance of %s] property !',
                static::class,
                PaginatorInterface::class
            ));
        }

        $queryBuilder = $this->getQueryBuilderByCriteria($criteria);

        return $this->paginator->paginate($queryBuilder, $criteria->getPage(), $criteria->getLimit());
    }
}
