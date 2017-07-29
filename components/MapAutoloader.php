<?php

namespace components;

/**
 * Class MapAutoloader
 * @package components
 */
class MapAutoloader
{
    /**
     * @var array
     */
    protected $classesMap = [];

    /**
     * @var string
     */
    private $rout = '';

    /**
     * MapAutoloader constructor.
     * @param $rout (Project base directory)
     */
    public function __construct($rout)
    {
        $this->rout = $rout;
    }

    /**
     * @param string $className
     * @param string $absolutePath
     * @return bool
     */
    public function registerClass($className, $absolutePath)
    {
        if (file_exists($absolutePath)) {
            $this->classesMap[$className] = $absolutePath;
            return true;
        }

        return false;
    }

    /**
     * @param string $class
     * @return bool
     */
    public function autoload($class)
    {
        $classRout = $this->rout . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

        if (array_key_exists($class, $this->classesMap) || $this->registerClass($class, $classRout)) {
            return require_once($this->classesMap[$class]);
        }

        return false;
    }
}
