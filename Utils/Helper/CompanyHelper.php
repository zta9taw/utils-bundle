<?php

declare(strict_types=1);

namespace App\Utils\Helper;

use App\Entity\AbstractCompany;
use App\Entity\CspsCoordinator;
use App\Entity\Enterprise;
use App\Entity\ProjectManager;
use App\Entity\ProjectOwner;
use App\Entity\UserProfile;
use InvalidArgumentException;

/**
 * Class CompanyHelper
 */
class CompanyHelper
{
    const COMPANY_TYPE_CLASS_MAPPING = [
        ProjectOwner::TYPE => ProjectOwner::class,
        ProjectManager::TYPE => ProjectManager::class,
        CspsCoordinator::TYPE => CspsCoordinator::class,
        Enterprise::TYPE => Enterprise::class,
    ];

    /**
     * @param AbstractCompany $company
     *
     * @return UserProfile
     */
    public static function getAdmin(AbstractCompany $company): UserProfile
    {
        /** @var UserProfile $profile */
        foreach ($company->getProfiles() as $profile) {
            if ($profile->isAdmin()) {
                return $profile;
            }
        }

        throw new InvalidArgumentException('The given company does not have an admin !');
    }
}
