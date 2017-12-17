<?php

namespace GL\Support\Helpers;

final class MobileHelper
{
    /**
     * check whether given mobile is valid or not
     *
     * @param string $mobile  mobile to check
     * @return bool           true if given mobile is valid, false otherwise
     */
    public static function valid($mobile)
    {
        return preg_match('/^1[34578]\d{9}$/', $mobile) > 0;
    }
}