<?php

namespace admin\controllers;

use models\Comment;
use web\components\Controller;

/**
 * Class IndexController
 * @package admin\controllers
 */
class IndexController extends Controller
{
    public function actionIndex()
    {
        $comments = (new Comment())->find(['is_moderated' => false]);
        return $this->render('index', ['comments' => $comments]);
    }
}
