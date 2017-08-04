<?php

namespace components\console;

/**
 * Class Dispatcher
 * @package components\console
 */
class Dispatcher extends \components\Dispatcher
{
    public function dispatch()
    {
        global $argv;
        $arguments = $argv;
        array_shift($arguments);

        $action = array_shift($arguments);
        if (empty($action)) {
            throw new \Exception('Action is required');
        }

        $params = [];
        foreach ($arguments as $argument) {
            $parts = explode('=', $argument);
            if (count($parts) < 2) {
                continue;
            }

            $params[] = array_shift($parts);
            $params[] = array_shift($parts);
        }

        $this->attributes = array_merge(explode('/', $action), $params);
    }
}