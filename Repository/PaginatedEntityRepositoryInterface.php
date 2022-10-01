<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Repository;

use Zta9taw\Bundle\UtilsBundle\Repository\Criteria\PaginatedCriteriaInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;

interface PaginatedEntityRepositoryInterface extends EntityRepositoryInterface
{
    public function findPaginatedByCriteria(PaginatedCriteriaInterface $criteria): PaginationInterface;
}
