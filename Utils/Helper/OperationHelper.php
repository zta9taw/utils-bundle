<?php

declare(strict_types=1);

namespace App\Utils\Helper;

use App\Repository\Criteria\DefaultCriteria;

/**
 * Class OperationHelper
 */
class OperationHelper
{
    const LIST_OPERATION = 'list';
    const VIEW_OPERATION = 'view';
    const CREATE_OPERATION = 'create';
    const UPDATE_OPERATION = 'update';
    const ARCHIVE_UNARCHIVE_OPERATION = 'archive_unarchive';
    const DEFAULT_CRITERIA = DefaultCriteria::class;
}
