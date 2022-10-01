<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Repository\Criteria;

interface CriteriaInterface
{
    public function addCriterion(Criterion $criterion): static;

    public function getCriterion(string $name): ?Criterion;

    public function getCriteria(bool $exceptNullValue = true): iterable;

    public function addOrder(Order $order): static;

    public function getOrders(): iterable;

    public function getAllowedCriteria(): array;

    public function getAllowedOrders(): array;

    public function removeCriterion(string $field): static;
}
