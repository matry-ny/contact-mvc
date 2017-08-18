<?php

namespace helpers;

use components\Application;

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
        $baseUrl = trim(Config::getInstance()->get('baseUrl'), " \t\n\r\0\x0B/") . '/';
        if (APP_TYPE == Application::ADMIN) {
            $baseUrl .= 'admin';
        }

        if (strpos($url, $baseUrl) !== 0) {
            $url = vsprintf('/%s/%s', [trim($baseUrl, " \t\n\r\0\x0B/"), trim($url, " \t\n\r\0\x0B/")]);
        }

        return $url;
    }

    /**
     * @return string
     */
    public static function getClearAddress()
    {
        $url = trim($_SERVER["REQUEST_URI"], " \t\n\r\0\x0B/");
        $baseUrl = Config::getInstance()->get('baseUrl');

        if (strpos($url, $baseUrl) === 0) {
            $url = substr($url, strlen($baseUrl));
        }
        if (APP_TYPE == Application::ADMIN && strpos($url, 'admin') === 0) {
            $url = substr($url, 5);
        }

        return $url;
    }
}