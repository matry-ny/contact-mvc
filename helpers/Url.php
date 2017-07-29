<?php
/**
 * Created by PhpStorm.
 * User: 32
 * Date: 24.07.2017
 * Time: 20:54
 */

namespace helpers;


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
}