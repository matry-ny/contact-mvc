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
        $model->load([
            'user_name' => 'QQ',
            'comment' => 'Some comment'
        ]);
        $model->save();
        exit;


        return $this->render('index');
    }

    public function action404()
    {
        echo 404;
    }
}
