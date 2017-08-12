<?php

namespace helpers;

/**
 * Class Bootstrap
 * @package helpers
 */
class Bootstrap
{
    /**
     * @param string $file
     * @return string
     */
    public static function getFileUrl($file)
    {
        return Url::prepare('/') . 'vendor/twbs/bootstrap/dist/' . $file;
    }
}
