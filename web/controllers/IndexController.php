<?php

namespace web\controllers;

use components\web\Controller;
use models\Comment;

/**
 * Class IndexController
 * @package web\controllers
 */
class IndexController extends Controller
{
    public function actionIndex()
    {
        $model = new Comment();

        return $this->render('index', ['records' => $model->find([])]);
    }

    public function action404()
    {
        echo 404;
    }
}
