<?php

namespace components\web;

use components\Registry;

/**
 * Class Application
 * @package components\web
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
        Registry::set('template', (new Template()));
    }
}
