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
        $models = (new Comment())->find(['is_moderated' => true]);

        return $this->render('index', ['records' => $models]);
    }
}
