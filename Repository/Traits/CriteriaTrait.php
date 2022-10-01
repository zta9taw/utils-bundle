<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Repository\Traits;

use Zta9taw\Bundle\UtilsBundle\Repository\Criteria\Criterion;
use Zta9taw\Bundle\UtilsBundle\Repository\Criteria\Order;

trait CriteriaTrait
{
    protected array $criteria = [];

    protected array $orders = [];

    public function addCriterion(Criterion $criterion): static
    {
        $this->criteria[] = $criterion;

        return $this;
    }

    public function getCriterion(string $name): ?Criterion
    {
        foreach ($this->criteria as $criterion) {
            if ($criterion->field === $name) {
                return $criterion;
            }
        }

        return null;
    }

    public function getCriteria(bool $exceptNullValue = true): iterable
    {
        if (!$exceptNullValue) {
            return $this->criteria;
        }

        return array_filter($this->criteria, function (Criterion $criterion) {
            return !is_null($criterion->value);
        });
    }

    public function addOrder(Order $order): static
    {
        $this->orders[] = $order;

        return $this;
    }

    public function getOrders(): iterable
    {
        return $this->orders;
    }

    public function getAllowedCriteria(): array
    {
        return [];
    }

    public function getAllowedOrders(): array
    {
        return [];
    }

    public function removeCriterion(string $field): static
    {
        foreach ($this->criteria as $index => $criterion) {
            if ($field === $criterion->field) {
                unset($this->criteria[$index]);

                break;
            }
        }

        return $this;
    }
}
