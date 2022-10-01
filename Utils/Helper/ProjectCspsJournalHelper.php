<?php

declare(strict_types=1);

namespace App\Utils\Helper;

/**
 * Class ProjectCspsJournalHelper
 */
class ProjectCspsJournalHelper
{
    const OPENED = 'OPENED';
    const CLOSED = 'CLOSED';
    const URGENT = 'URGENT';
    const INFORMATION = 'INFORMATION';
    const STATUSES = [
        self::OPENED,
        self::CLOSED,
        self::URGENT,
        self::INFORMATION,
    ];
}
