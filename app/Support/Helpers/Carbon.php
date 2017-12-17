<?php

namespace GL\Support\Helpers;

use Carbon\Carbon as BaseCarbon;

/**
 * Helper method for Carbon
 */
final class Carbon
{
    /**
     * @param string|null $time
     * @param \DateTimeZone|string|null $tz
     * @return BaseCarbon|null
     */
    public static function create(string $time = null, $tz = null)
    {
        if (!$time) {
            return null;
        }

        return BaseCarbon::createFromTimestamp(strtotime($time, BaseCarbon::now()->timestamp), $tz);
    }

    /**
     * Get the first day of month for given date
     *
     * @param BaseCarbon $date
     * @return BaseCarbon
     */
    public static function getFirstDayOf(BaseCarbon $date)
    {
        return $date->copy()->firstOfMonth();
    }
}