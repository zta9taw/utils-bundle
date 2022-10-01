<?php

declare(strict_types=1);

namespace App\Utils\Helper;

use App\Entity\AbstractCompany;
use App\Entity\CspsCoordinator;
use App\Entity\Enterprise;
use App\Entity\ProjectInvitation;
use App\Entity\ProjectManager;
use App\Entity\ProjectOwner;
use App\Entity\User;

/**
 * Class ProjectInvitationHelper
 */
class ProjectInvitationHelper
{
    const STATUS_PENDING = 'Pending';
    const STATUS_ACCEPTED = 'Accepted';
    const STATUS_REJECTED = 'Rejected';
    const STATUS_CANCELLED = 'Cancelled';
    const STATUS_CONFIRMED = 'Confirmed';
    const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_CANCELLED,
        self::STATUS_CONFIRMED,
        self::STATUS_REJECTED,
        self::STATUS_ACCEPTED,
    ];
    const INVITATION_RULES = [
        ProjectOwner::TYPE => [
            Enterprise::TYPE,
            ProjectManager::TYPE,
            CspsCoordinator::TYPE,
        ],
        Enterprise::TYPE => [
            Enterprise::TYPE,
        ],
        ProjectManager::TYPE => [
            Enterprise::TYPE,
            ProjectManager::TYPE,
        ],
        CspsCoordinator::TYPE => [
            CspsCoordinator::TYPE,
        ],
    ];

    /**
     * @param ProjectInvitation $projectInvitation
     *
     * @return string
     */
    public static function getStatus(ProjectInvitation $projectInvitation): string
    {
        if ($projectInvitation->getAcceptedAt()) {
            return self::STATUS_ACCEPTED;
        }

        if ($projectInvitation->getConfirmedAt()) {
            return self::STATUS_CONFIRMED;
        }

        if ($projectInvitation->getCancelledAt()) {
            return self::STATUS_CANCELLED;
        }

        if ($projectInvitation->getRejectedAt()) {
            return self::STATUS_REJECTED;
        }

        return self::STATUS_PENDING;
    }

    /**
     * @param ProjectInvitation $projectInvitation
     *
     * @return string
     */
    public static function getGuest(ProjectInvitation $projectInvitation): string
    {
        return $projectInvitation->getGuestProfile()
            ? PersonHelper::getFullName($projectInvitation->getGuestProfile())
            : $projectInvitation->getGuestEmail();
    }

    /**
     * @return string
     */
    public static function generateToken(): string
    {
        return md5(time().uniqid());
    }

    /**
     * @param ProjectInvitation $projectInvitation
     *
     * @return bool
     */
    public static function needConfirmation(ProjectInvitation $projectInvitation): bool
    {
        return $projectInvitation->getGuestCompany() && !empty($projectInvitation->getGuestEmail());
    }

    /**
     * @param ProjectInvitation $projectInvitation
     *
     * @return bool
     */
    public static function isConfirmed(ProjectInvitation $projectInvitation): bool
    {
        return !static::needConfirmation($projectInvitation) || $projectInvitation->getConfirmedAt();
    }

    /**
     * @param ProjectInvitation $projectInvitation
     *
     * @return bool
     */
    public static function isPending(ProjectInvitation $projectInvitation): bool
    {
        return empty($projectInvitation->getAcceptedAt()) && empty($projectInvitation->getRejectedAt()) && empty($projectInvitation->getCancelledAt());
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public static function getAllowedGuestType(User $user): array
    {
        return self::INVITATION_RULES[$user->getProfile()?->getCompany()?->getType()] ?? [];
    }

    /**
     * @param User                   $user
     * @param AbstractCompany|string $company
     *
     * @return bool
     */
    public static function canInvite(User $user, AbstractCompany|string $company): bool
    {
        if (empty($user->getProfile()?->getCompany())) {
            return false;
        }

        $companyType = $company instanceof AbstractCompany ? $company->getType() : $company;

        return in_array($companyType, self::INVITATION_RULES[$user->getProfile()->getCompany()->getType()]);
    }
}
