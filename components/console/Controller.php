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
     */
    public function printOut($string)
    {
        echo $string . PHP_EOL;
    }
}
