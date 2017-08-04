<?php

namespace helpers;

/**
 * Class Url
 * @package helpers
 */
class Url
{
    /**
     * @param string $url
     * @return string
     */
    public static function prepare($url)
    {
        $baseUrl = Config::getInstance()->get('baseUrl');

        if (strpos($url, $baseUrl) !== 0) {
            $url = vsprintf('/%s/%s', [
                trim($baseUrl, " \t\n\r\0\x0B/"),
                trim($url, " \t\n\r\0\x0B/")
            ]);
        }

        return $url;
    }

    /**
     * @return string
     */
    public static function getClearAddress()
    {
        $url = $_SERVER["REQUEST_URI"];
        $baseUrl = Config::getInstance()->get('baseUrl');

        if (strpos($url, $baseUrl) === 0) {
            $url = substr($url, strlen($baseUrl));
        }

        return $url;
    }
}