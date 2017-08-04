<?php

namespace components;

/**
 * Class Router
 * @package components
 */
final class Router
{
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * Router constructor.
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @return mixed
     */
    public function run()
    {
        return $this->runAction();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    private function runAction()
    {
        if (!class_exists($this->dispatcher->getController())) {
            throw new \Exception("Class '{$this->dispatcher->getController()}' is undefined");
        }

        $controller = $this->dispatcher->getController();
        $controllerObject = new $controller();

        if (!method_exists($controllerObject, $this->dispatcher->getAction())) {
            $message = vsprintf('Action "%s" is not allowed for class "%s"', [
                $this->dispatcher->getAction(),
                $this->dispatcher->getController()
            ]);
            throw new \Exception($message);
        }

        return call_user_func_array(
            [$controllerObject, $this->dispatcher->getAction()],
            $this->dispatcher->getParams()
        );
    }
}
