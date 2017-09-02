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

        $params = $this->getArgumentsArray(
            $controllerObject,
            $this->dispatcher->getAction(),
            $this->dispatcher->getParams()
        );

        return call_user_func_array([$controllerObject, $this->dispatcher->getAction()], $params);
    }

    /**
     * @param Controller $controller
     * @param string $action
     * @param array $params
     * @return array
     * @throws \Exception
     */
    private function getArgumentsArray(Controller $controller, $action, array $params = [])
    {
        $reflectionController = new \ReflectionObject($controller);
        $reflectionAction = $reflectionController->getMethod($action);

        $requiredParams = [];
        $additionalParams = [];

        $requiredParamsQuantity = $reflectionAction->getNumberOfRequiredParameters();
        foreach ($reflectionAction->getParameters() as $index => $param) {
            if ($index < $requiredParamsQuantity) {
                $requiredParams[] = $param->getName();
            } else {
                $additionalParams[$param->getName()] = $param->getDefaultValue();
            }
        }

        $result = [];

        foreach ($requiredParams as $requiredParam) {
            if (array_key_exists($requiredParam, $params)) {
                $result[$requiredParam] = $params[$requiredParam];
            } else {
                throw new \Exception("Required parameter '{$requiredParam}' is not transferred");
            }
        }

        foreach ($additionalParams as $key => $defaultValue) {
            $result[$key] = array_key_exists($key, $params) ? $params[$key] : $defaultValue;
        }

        return $result;
    }
}
