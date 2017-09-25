<?php
/**
 * Created by PhpStorm.
 * User: 32
 * Date: 25.09.2017
 * Time: 20:20
 */

namespace helpers;


class ArrayHelper
{
    /**
     * @param array $array
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getValue($array, $key, $default = null)
    {
        return array_key_exists($key, $array) ? $array[$key] : $default;
    }
}