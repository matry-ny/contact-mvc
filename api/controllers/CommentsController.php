<?php

namespace api\controllers;

use components\api\Controller;
use helpers\Behaviors;
use helpers\Request;

/**
 * Class CommentsController
 * @package api\controllers
 */
class CommentsController extends Controller
{
    /**
     * @return array
     */
    protected function behaviors()
    {
        return [
            Behaviors::PROTOCOLS => [
                'get-comments-by-user-id' => Request::GET
            ]
        ];
    }

    public function actionGetCommentsByUserId($userId)
    {
        var_dump($userId);
    }
}