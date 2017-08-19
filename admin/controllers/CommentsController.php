<?php

namespace admin\controllers;

use models\Comment;
use web\components\Controller;

/**
 * Class CommentsController
 * @package admin\controllers
 */
class CommentsController extends Controller
{
    /**
     * @param int $id
     */
    public function actionModerate($id)
    {
        $model = (new Comment())->find($id);
        if (empty($model)) {
            $this->getSession()->addFlash('error', "Comment #{$id} is undefined");
            $this->redirect('/');
        }

        $model->load(['is_moderated' => true]);
        $model->save();

        $this->getSession()->addFlash('success', "Comment #{$id} has been moderated successfully");
        $this->redirect('/');
    }

    public function actionDelete($id)
    {
        $model = (new Comment())->find($id);
        if (empty($model)) {
            $this->getSession()->addFlash('error', "Comment #{$id} is undefined");
            $this->redirect('/');
        }

        $model->delete();

        $this->getSession()->addFlash('success', "Comment #{$id} has been deleted successfully");
        $this->redirect('/');
    }
}
