<?php

namespace web\controllers;

use models\Comment;
use web\components\Controller;

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
}
