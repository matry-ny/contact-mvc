<?php

namespace web\controllers;

use models\Comment;
use web\components\Controller;

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
        $model->load(['author' => $this->getUser()->getId()]);
        if ($model->save()) {
            $this->getSession()->addFlash('success', "Comment #{$model->id} has been created successfully");
        } else {
            $this->getSession()->addFlash('error', "Comment can not be created");
        }

        $this->redirect('/');
    }

    /**
     * @param int $id
     * @return string
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'comment' => $this->getModel($id)
        ]);
    }

    /**
     * @param int $id
     */
    public function actionUpdate($id)
    {
        $model = $this->getModel($id);
        $model->load($_POST);

        if ($model->save()) {
            $this->getSession()->addFlash('success', "Comment #{$id} has been updated successfully");
        } else {
            $this->getSession()->addFlash('error', "Comment #{$id} can not be updated");
        }

        $this->redirect("/comments/view/id/{$id}");
    }

    /**
     * @param int $id
     */
    public function actionDelete($id)
    {
        $model = $this->getModel($id);
        if ($model->delete()) {
            $this->getSession()->addFlash('success', "Comment #{$id} has been deleted successfully");
        } else {
            $this->getSession()->addFlash('error', "Comment #{$id} can not be deleted");
        }

        $this->redirect('/');
    }

    /**
     * @param int $id
     * @return array|\components\Model
     * @throws \Exception
     */
    private function getModel($id)
    {
        $model = (new Comment())->find($id);
        if (empty($model)) {
            throw new \Exception("Comment #{$id} can not be found");
        }

        return $model;
    }
}
