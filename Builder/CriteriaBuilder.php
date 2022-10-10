<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Builder;

use Zta9taw\Bundle\UtilsBundle\Repository\Criteria\CriteriaInterface;
use Zta9taw\Bundle\UtilsBundle\Repository\Criteria\Criterion;
use Zta9taw\Bundle\UtilsBundle\Repository\Criteria\Order;
use Zta9taw\Bundle\UtilsBundle\Repository\Criteria\PaginatedCriteriaInterface;

class CriteriaBuilder
{
    private const PAGINATION_FIELDS = ['page', 'limit'];

    /**
     * @var CriteriaInterface|PaginatedCriteriaInterface
     */
    private static CriteriaInterface|PaginatedCriteriaInterface $criteria;

    /**
     * @param string $criteriaClass
     * @param array  $criteria
     * @param array  $orders
     *
     * @return CriteriaInterface|PaginatedCriteriaInterface
     */
    public static function buildCriteria(string $criteriaClass, array $criteria = [], array $orders = []): CriteriaInterface|PaginatedCriteriaInterface
    {
        if (!class_exists($criteriaClass)) {
            throw new \LogicException(sprintf('The criteria class %s not found', $criteriaClass));
        }

        static::$criteria = new $criteriaClass();
        if (!static::$criteria instanceof CriteriaInterface) {
            throw new \InvalidArgumentException(sprintf('The criteria class %s must implement %s interface', $criteriaClass, CriteriaInterface::class));
        }

        static::hydrateCriteria($criteria);
        static::hydrateOrders($orders);

        if (static::$criteria instanceof PaginatedCriteriaInterface) {
            static::$criteria->setPage($criteria['page'] ?? PaginatedCriteriaInterface::DEFAULT_PAGE);
            static::$criteria->setLimit($criteria['limit'] ?? PaginatedCriteriaInterface::DEFAULT_LIMIT);
        }

        return static::$criteria;
    }

    /**
     * @param array $criteria
     */
    private static function hydrateCriteria(array $criteria): void
    {
        foreach ($criteria as $fieldName => $fieldValue) {
            if (in_array($fieldName, self::PAGINATION_FIELDS)) {
                continue;
            }

            if (!in_array($fieldName, static::$criteria->getAllowedCriteria())) {
                continue;
            }

            static::$criteria->addCriterion(new Criterion($fieldName, $fieldValue));
        }
    }

    /**
     * @param array $orders
     */
    private static function hydrateOrders(array $orders): void
    {
        foreach ($orders as $fieldName => $direction) {
            if (!in_array($fieldName, static::$criteria->getAllowedOrders())) {
                continue;
            }
            static::$criteria->addOrder(new Order($fieldName, $direction));
        }
    }
}
