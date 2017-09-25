<?php

namespace components\api;

use components\Registry;
use components\Session;

/**
 * Class Application
 * @package components\api
 */
class Application extends \components\Application
{
    public function run()
    {
        $this->setUp();
        parent::run();
    }

    private function setUp()
    {
        Registry::set('session', new Session());
    }
}
