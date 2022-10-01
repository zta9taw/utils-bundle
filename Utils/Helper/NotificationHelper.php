<?php

declare(strict_types=1);

namespace App\Utils\Helper;

use App\Entity\Notification;
use DateTime;

/**
 * Class NotificationHelper
 */
class NotificationHelper
{
    /**
     * @param Notification $notification
     *
     * @return array|null
     */
    public static function getCreationDuration(Notification $notification): ?array
    {
        $diff = $notification->getCreatedAt()->diff(new DateTime());
        if ($diff->y) {
            return [$diff->y, 'Year(s)'];
        }

        if ($diff->m) {
            return [$diff->m, 'Month(s)'];
        }

        if ($diff->d) {
            return [$diff->d, 'Day(s)'];
        }

        if ($diff->h) {
            return [$diff->h, 'Hour(s)'];
        }

        if ($diff->i) {
            return [$diff->i, 'Minute(s)'];
        }

        if ($diff->s) {
            return [$diff->s, 'Second(s)'];
        }

        return null;
    }
}
