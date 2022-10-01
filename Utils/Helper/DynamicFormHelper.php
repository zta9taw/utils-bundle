<?php

declare(strict_types=1);

namespace App\Utils\Helper;

use App\Entity\Machine;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DynamicFormHelper
 */
class DynamicFormHelper
{
    /**
     * @param EntityRepository $repository
     *
     * @return QueryBuilder
     */
    public static function getActiveEntitiesQueryBuilder(EntityRepository $repository): QueryBuilder
    {
        return $repository->createQueryBuilder('entity')
            ->where('entity.archived = :archived')
            ->setParameter('archived', false);
    }

    /**
     * @param Machine $choice
     * @param mixed   $key
     * @param mixed   $value
     *
     * @return array
     */
    public static function machineChoiceAttribute(Machine $choice, mixed $key, mixed $value): array
    {
        return ['data-information' => $choice->getInformation()];
    }
}
