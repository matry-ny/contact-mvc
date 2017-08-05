<?php

namespace web\controllers;

use components\web\Controller;
use models\Comment;

/**
 * Class CommentsController
 * @package web\controllers
 */
class CommentsController extends Controller
{
    public function actionCreate()
    {
        $model = new Comment();
        $model->load($_POST);
        $model->save();

        return 'Saved';
    }

}
