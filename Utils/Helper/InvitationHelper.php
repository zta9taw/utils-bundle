<?php

declare(strict_types=1);

namespace App\Utils\Helper;

use App\Entity\Invitation;

/**
 * Class InvitationHelper
 */
class InvitationHelper
{
    const IN_PROGRESS_STATUS = 'IN_PROGRESS';
    const ACCEPTED_STATUS = 'ACCEPTED';
    const CANCELLED_STATUS = 'CANCELLED';

    /**
     * @return string
     */
    public static function generateToken(): string
    {
        return md5(time().uniqid());
    }

    /**
     * @param Invitation $invitation
     *
     * @return bool
     */
    public static function isAccepted(Invitation $invitation): bool
    {
        return self::ACCEPTED_STATUS === $invitation->getStatus();
    }

    /**
     * @param Invitation $invitation
     *
     * @return bool
     */
    public static function isInProgress(Invitation $invitation): bool
    {
        return self::IN_PROGRESS_STATUS === $invitation->getStatus();
    }

    /**
     * @param Invitation $invitation
     *
     * @return bool
     */
    public static function isCancelled(Invitation $invitation): bool
    {
        return self::CANCELLED_STATUS === $invitation->getStatus();
    }
}
