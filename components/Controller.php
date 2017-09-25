<?php

namespace components;

use helpers\Config;
use helpers\Strings;

/**
 * Class Controller
 * @package components
 */
abstract class Controller
{
    /**
     * @var null|string
     */
    private $calledMethod = null;

    /**
     * @param string $calledMethod
     */
    public function setCalledMethod($calledMethod)
    {
        $this->calledMethod = $calledMethod;
    }

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

        return Strings::reCamelize(substr($class, 0, -10));
    }

    /**
     * @return \components\Router
     */
    protected function getRouter()
    {
        return Registry::get('router');
    }

    /**
     * @return string
     */
    protected function getCalledMethod()
    {
        $calledMethod = $this->getRouter()->getDispatcher()->getAction();
        return Strings::reCamelize(substr($calledMethod, 6));
    }
}
