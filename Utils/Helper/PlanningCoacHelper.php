<?php

declare(strict_types=1);

namespace App\Utils\Helper;

use App\Business\Project\PlanningCoacBatchPhaseActivity;
use App\Business\Project\PlanningCoacBox;
use DateTime;
use DateTimeInterface;
use InvalidArgumentException;

/**
 * Class PlanningCoacHelper
 */
class PlanningCoacHelper
{
    const WEEK_PERIOD = 'WEEK';
    const MONTH_PERIOD = 'MONTH';
    const QUARTER_PERIOD = 'QUARTER';

    /**
     * @param DateTimeInterface $startDate
     * @param DateTimeInterface $endDate
     * @param string            $unity
     *
     * @return int
     */
    public static function calculateCasesCount(DateTimeInterface $startDate, DateTimeInterface $endDate, string $unity = self::WEEK_PERIOD): int
    {
        $interval = date_diff($startDate, $endDate);
        if (self::WEEK_PERIOD === $unity) {
            return (int) ceil($interval->days / 7);
        }

        if (self::MONTH_PERIOD === $unity) {
            return $interval->days ? $interval->m + 1 : $interval->m;
        }

        if (self::QUARTER_PERIOD === $unity) {
            $monthCount = $interval->days ? $interval->m + 1 : $interval->m;

            return (int) ceil($monthCount / 3);
        }

        throw new InvalidArgumentException('Invalid unity given !');
    }

    /**
     * @param PlanningCoacBox                $box
     * @param PlanningCoacBatchPhaseActivity $activity
     *
     * @return bool
     */
    public static function isActivityInBox(PlanningCoacBox $box, PlanningCoacBatchPhaseActivity $activity): bool
    {
        return ($activity->getStartDate() >= $box->getStartDate() && $activity->getStartDate() <= $box->getEndDate())
            || ($activity->getEndDate() >= $box->getStartDate() && $activity->getEndDate() <= $box->getEndDate())
            || ($box->getStartDate() > $activity->getStartDate() && $box->getEndDate() < $activity->getEndDate())
            ;
    }

    /**
     * @param DateTimeInterface $dateTime
     * @param string            $unity
     *
     * @return DateTimeInterface
     */
    public static function calculateFirstDay(DateTimeInterface $dateTime, string $unity): DateTimeInterface
    {
        if (self::WEEK_PERIOD === $unity) {
            return (new DateTime())->setTimestamp(strtotime('monday this week', $dateTime->getTimestamp()));
        }

        return (new DateTime())->setTimestamp(strtotime('first day of this month', $dateTime->getTimestamp()));
    }

    /**
     * @param DateTimeInterface $dateTime
     * @param string            $unity
     *
     * @return DateTimeInterface
     */
    public static function calculateLastDay(DateTimeInterface $dateTime, string $unity): DateTimeInterface
    {
        if (self::WEEK_PERIOD === $unity) {
            return (new DateTime())->setTimestamp(strtotime('sunday this week', $dateTime->getTimestamp()));
        }

        return (new DateTime())->setTimestamp(strtotime('last day of this month', $dateTime->getTimestamp()));
    }
}
