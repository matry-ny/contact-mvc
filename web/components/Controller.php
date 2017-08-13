<?php

namespace web\components;

/**
 * Class Controller
 * @package web\components
 */
class Controller extends \components\web\Controller
{
    public function __construct()
    {
        if ($this->getUser()->getIsGuest()) {
            $this->redirect('/guest/login');
        }
    }
}
