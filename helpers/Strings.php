<?php

namespace helpers;

/**
 * Class Strings
 * @package helpers
 */
class Strings
{
    /**
     * @param string $name
     * @return string
     */
    public static function camelize($name)
    {
        $nameParts = explode('-', $name);
        array_walk($nameParts, function (&$part) {
            $part = ucfirst(strtolower($part));
        });

        return implode($nameParts);
    }
}
