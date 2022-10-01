<?php

declare(strict_types=1);

namespace App\Utils\Helper;

use Symfony\Component\Yaml\Yaml;

/**
 * Class ReferenceHelper
 */
class ReferenceHelper
{
    const PROJECT_OPERATION_TYPE_REFERENCE = 'operation_type';
    const PROJECT_WORK_TYPE_REFERENCE = 'work_type';
    const PROJECT_TYPE_REFERENCE = 'type';
    const PROJECT_CATEGORY_ERP_REFERENCE = 'category_erp';
    const PROJECT_CATEGORY_ERP_TYPE_REFERENCE = 'category_erp_type';
    const PROJECT_MANAGER_SPECIALITY_REFERENCE = 'project_manager_speciality';
    const IUO_NAME_REFERENCE = 'iuo_name';
    const CSPS_JOURNAL_SUBJECT_REFERENCE = 'csps_journal_subject';

    /**
     * @var array
     */
    public static array $references = [];

    /**
     * @var bool
     */
    private static bool $referencesLoaded = false;

    /**
     * @param string $reference
     *
     * @return array
     */
    public static function getReferenceValues(string $reference): array
    {
        static::loadReferences();
        if (!array_key_exists($reference, static::$references)) {
            throw new \InvalidArgumentException(sprintf(
                'The given reference %s is not configured, available references are [%s]',
                $reference,
                implode(',', array_key_first(static::$references))
            ));
        }

        return static::$references[$reference];
    }

    /**
     * Parse file yaml and load references.
     */
    protected static function loadReferences(): void
    {
        if (static::$referencesLoaded) {
            return;
        }

        static::$references = Yaml::parseFile(realpath(__DIR__.'/../../../config/references/references.yaml'));
        static::$referencesLoaded = true;
    }
}
