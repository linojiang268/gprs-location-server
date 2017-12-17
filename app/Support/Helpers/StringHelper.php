<?php

namespace GL\Support\Helpers;

use Illuminate\Support\Str;

class StringHelper
{
    /**
     * generate random text
     *
     * @param int $length     length of the generated text
     * @param string $pool    character pool
     *
     * @return string  generated random text
     */
    public static function quickRandom($length = 6, $pool = null)
    {
        if (empty($pool)) {
            return Str::random($length);
        }

        $repeats = ceil($length / strlen($pool));
        return substr(str_shuffle(str_repeat($pool, $repeats)), 0, $length);
    }

    /**
     * build a new order no with uniqid str
     *
     * @param string $sign
     * @return string
     * @throws \Exception
     */
    public static function buildOrderNo($sign = '') {
        if (is_null($sign) || !is_string($sign)) {
            throw new \Exception('build order no error because invalid sign');
        }

        // e.g. 2016100722320553999851   base length:22
        return date('YmdHis') . $sign . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }
}