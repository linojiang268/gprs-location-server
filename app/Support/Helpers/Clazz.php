<?php

namespace GL\Helpers;

/**
 * Helper method for PHP class
 */
final class Clazz
{
    /**
     * Get constant value
     *
     * @param string $class
     * @param string $name
     * @param mixed|null $default   default value
     * @return mixed
     */
    public static function getConstant(string $class, string $name, $default = null)
    {
        $field = sprintf("$class::$name");
        if (defined($field)) {
            return constant($field);
        }

        return $default;
    }
}