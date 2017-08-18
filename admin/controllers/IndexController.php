<?php

namespace admin\controllers;

use web\components\Controller;

/**
 * Class IndexController
 * @package admin\controllers
 */
class IndexController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
