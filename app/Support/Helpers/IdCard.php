<?php

namespace GL\Helpers;

use Carbon\Carbon as CCarbon;

final class IdCard
{
    /**
     * @param string $number
     * @return null|CCarbon
     */
    public static function extractBirthDate(string $number)
    {
        $birth = substr($number, 6, 8);

        if (checkdate($month = substr($birth, 4, 2),
                      $day   = substr($birth, 6, 2),
                      $year  = substr($birth, 0, 4))) {
            return CCarbon::createFromDate($year, $month, $day);
        }

        return null;
    }

    /**
     * @param string $number
     * @return bool  true for male, false for female
     */
    public static function deduceGender(string $number)
    {
        // the 2nd last digit shows the gender.
        // When it's an odd, the id card belong to a male.
        return substr($number, -2 ,1) % 2 == 1;
    }
}