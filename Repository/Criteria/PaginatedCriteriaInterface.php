<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Repository\Criteria;

interface PaginatedCriteriaInterface extends CriteriaInterface
{
    const DEFAULT_PAGE = 1;
    const DEFAULT_LIMIT = 10;

    public function setPage(int $page): static;

    public function setLimit(int $limit): static;

    public function getPage(): int;

    public function getLimit(): int;
}
