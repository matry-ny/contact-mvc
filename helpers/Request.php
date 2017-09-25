<?php

namespace helpers;

/**
 * Class Request
 * @package helpers
 */
class Request
{
    const GET = 'GET';
    const POST = 'POST';

    /**
     * @param null|string $key
     * @param null|mixed $default
     * @return mixed
     */
    public static function get($key = null, $default = null)
    {
        if ($key) {
            return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
        }

        return $_GET;
    }

    /**
     * @param null|string $key
     * @param null|mixed $default
     * @return mixed
     */
    public static function post($key = null, $default = null)
    {
        if ($key) {
            return array_key_exists($key, $_POST) ? $_POST[$key] : $default;
        }

        return $_POST;
    }

    /**
     * @param string $header
     * @return mixed
     */
    public static function getHeader($header)
    {
        return ArrayHelper::getValue(getallheaders(), $header);
    }
}
