<?php

namespace api\controllers;

use components\api\Controller;
use helpers\Behaviors;
use helpers\Request;
use models\Comment;

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

    /**
     * @param int $userId
     * @return array
     */
    public function actionGetCommentsByUserId($userId)
    {
        $comments = (new Comment())->find(['author' => $userId]);
        $result = [];
        foreach ($comments as $comment) {
            /** @var Comment $comment */
            $result[] = $comment->getAttributes();
        }

        return $result;
    }
}