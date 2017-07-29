<?php

namespace components;

use controllers\IndexController;
use helpers\Config;

/**
 * Class Router
 * @package components
 */
final class Router
{
    /**
     * @var string
     */
    private static $controller;

    /**
     * @var string
     */
    private static $action;

    /**
     * @var array
     */
    private static $params = [];

    /**
     * @return mixed
     */
    public static function dispatch()
    {
        $uriParts = explode('?', self::getCurrentUrl());
        $uri = urldecode(trim(reset($uriParts), '/'));
        $params = array_filter(explode('/', $uri));

        $controller = array_shift($params);
        self::$controller = self::prepareClassName($controller ?: 'index');

        $action = array_shift($params);
        self::$action = self::prepareActionName($action ?: 'index');

        $keys = [];
        $values = [];
        foreach ($params as $index => $value) {
            if ($index % 2 === 0) {
                $keys[] = $value;
            } else {
                $values[] = $value;
            }
        }

        self::$params = array_combine(array_slice($keys, 0, count($values)), $values);

        return self::executeAction();
    }

    /**
     * @param string $class
     * @return string
     */
    private static function prepareClassName($class)
    {
        return 'controllers\\' . self::camelize($class) . 'Controller';
    }

    /**
     * @param string $action
     * @return string
     */
    private static function prepareActionName($action)
    {
        return 'action' . self::camelize($action);
    }

    /**
     * @param string $name
     * @return string
     */
    private static function camelize($name)
    {
        $nameParts = explode('-', $name);
        array_walk($nameParts, function (&$part) {
            $part = ucfirst(strtolower($part));
        });

        return implode($nameParts);
    }

    /**
     * @return mixed
     */
    private static function executeAction()
    {
        if (!class_exists(self::$controller)) {
            return self::execute404Action();
        }

        $controller = new self::$controller();
        if (!method_exists($controller, self::$action)) {
            return self::execute404Action();
        }

        return call_user_func_array([$controller, self::$action], self::$params);
    }

    /**
     * @return mixed
     */
    private static function execute404Action()
    {
        return (new IndexController())->action404();
    }

    private static function getCurrentUrl()
    {
        $url = $_SERVER["REQUEST_URI"];
        $baseUrl = Config::getInstance()->get('baseUrl');

        if (strpos($url, $baseUrl) === 0) {
            $url = substr($url, strlen($baseUrl));
        }

        return $url;
    }
}
