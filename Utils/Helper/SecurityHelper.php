<?php

declare(strict_types=1);

namespace App\Utils\Helper;

use App\Entity\CspsCoordinator;
use App\Entity\Enterprise;
use App\Entity\ProjectManager;
use App\Entity\ProjectOwner;

/**
 * Class SecurityHelper
 */
class SecurityHelper
{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_COMPANY = 'ROLE_COMPANY';
    const ROLE_COMPANY_ADMIN = 'ROLE_COMPANY_ADMIN';
    const ROLE_ENTERPRISE = 'ROLE_ENTERPRISE';
    const ROLE_PROJECT_OWNER = 'ROLE_PROJECT_OWNER';
    const ROLE_PROJECT_MANAGER = 'ROLE_PROJECT_MANAGER';
    const ROLE_CSPS_COORDINATOR = 'ROLE_CSPS_COORDINATOR';

    private const PROFILE_ROLE = [
        Enterprise::TYPE => self::ROLE_ENTERPRISE,
        ProjectOwner::TYPE => self::ROLE_PROJECT_OWNER,
        ProjectManager::TYPE => self::ROLE_PROJECT_MANAGER,
        CspsCoordinator::TYPE => self::ROLE_CSPS_COORDINATOR,
    ];

    /**
     * @param string $profileType
     *
     * @return string
     */
    public static function guessRole(string $profileType): string
    {
        return self::PROFILE_ROLE[$profileType];
    }
}
