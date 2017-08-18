<?php

namespace admin\helpers;

use helpers\Url;

/**
 * Class Theme
 * @package admin\helpers
 */
class Theme
{
    /**
     * @param string $file
     * @return string
     */
    public static function getFileUrl($file)
    {
        return Url::prepare('/') . '../vendor/secondtruth/startmin/' . $file;
    }
}