<?php

namespace web\controllers;

use components\web\Controller;

/**
 * Class IndexController
 * @package web\controllers
 */
class IndexController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function action404()
    {
        echo 404;
    }
}
