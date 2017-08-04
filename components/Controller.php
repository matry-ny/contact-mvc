<?php

namespace components;

use helpers\Config;

/**
 * Class Controller
 * @package components
 */
abstract class Controller
{
    /**
     * @return Config
     */
    protected function getConfig()
    {
        return Config::getInstance();
    }

    /**
     * @return string
     */
    protected function getCalledController()
    {
        $classParts = explode('\\', get_called_class());
        $class = end($classParts);
        $class = substr($class, 0, -10);
        return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '-$0', $class)), '-');
    }
}
