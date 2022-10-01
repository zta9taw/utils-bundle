<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Repository\Traits;

trait PaginatedCriteriaTrait
{
    protected int $page = 1;

    protected int $limit = 20;

    public function setPage(int $page): static
    {
        if (1 > $page) {
            $page = 1;
        }

        $this->page = $page;

        return $this;
    }

    public function setLimit(int $limit): static
    {
        if (1 > $limit) {
            $limit = 20;
        }

        $this->limit = $limit;

        return $this;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
