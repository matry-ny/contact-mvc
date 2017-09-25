<?php

namespace components;

use helpers\Strings;

/**
 * Class Dispatcher
 * @package components
 */
abstract class Dispatcher
{
    const DEFAULT_CONTROLLER = 'index';
    const DEFAULT_ACTION = 'index';

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var null|string
     */
    protected $controller = null;

    /**
     * @var null|string
     */
    protected $action = null;

    /**
     * @var array
     */
    protected $params = [];

    public function __construct()
    {
        $this->dispatch();
        $this->run();
    }

    abstract public function dispatch();

    protected function run()
    {
        $this->prepareControllerName(array_shift($this->attributes));
        $this->prepareActionName(array_shift($this->attributes));
        $this->prepareParamsArray($this->attributes);
    }

    /**
     * @param string $class
     */
    protected function prepareControllerName($class)
    {
        switch (APP_TYPE) {
            case Application::WEB:
                $namespace = 'web';
                break;
            case Application::ADMIN:
                $namespace = 'admin';
                break;
            case Application::API:
                $namespace = 'api';
                break;
            case Application::CONSOLE:
                $namespace = 'console';
                break;
            default:
                $namespace = '';
        }

        $this->controller = vsprintf('%s\\controllers\\%sController', [
            $namespace,
            Strings::camelize($class ?: self::DEFAULT_CONTROLLER)
        ]);
    }

    /**
     * @param string $action
     */
    protected function prepareActionName($action)
    {
        $this->action = 'action' . Strings::camelize($action ?: self::DEFAULT_ACTION);
    }

    /**
     * @param array $params
     */
    protected function prepareParamsArray(array $params)
    {
        $keys = [];
        $values = [];
        foreach ($params as $index => $value) {
            if ($index % 2 === 0) {
                $keys[] = $value;
            } else {
                $values[] = $value;
            }
        }

        $this->params = array_combine(array_slice($keys, 0, count($values)), $values);
    }

    /**
     * @return null|string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return null|string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
}
