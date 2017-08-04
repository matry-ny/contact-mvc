<?php

namespace components\console;

/**
 * Class Controller
 * @package components\console
 */
class Controller extends \components\Controller
{
    /**
     * @var int
     */
    private $startTime;

    public function __construct()
    {
        $this->startTime = time();
    }

    /**
     * @return int
     */
    public function getExecutionTime()
    {
        return time() - $this->startTime;
    }

    /**
     * @param string $string
     * @return string
     */
    public function printOut($string)
    {
        return $string . PHP_EOL;
    }
}
