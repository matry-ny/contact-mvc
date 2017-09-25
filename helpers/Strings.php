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

    /**
     * @param string $name
     * @return string
     */
    public static function reCamelize($name)
    {
        return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '-$0', $name)), '-');
    }
}
