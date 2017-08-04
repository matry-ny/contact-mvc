<?php

namespace components\web;

use helpers\Url;

/**
 * Class Dispatcher
 * @package components\web
 */
class Dispatcher extends \components\Dispatcher
{
    public function dispatch()
    {
        $uriParts = explode('?', Url::getClearAddress());
        $uri = urldecode(trim(reset($uriParts), '/'));
        $this->attributes = array_filter(explode('/', $uri));
    }
}