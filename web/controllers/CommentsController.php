<?php

namespace web\controllers;

use components\web\Controller;
use helpers\Url;
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

    public function actionUpdate($id)
    {
        $model = $this->getModel($id);
        $model->load($_POST);

        $model->save();

        $this->redirect(Url::prepare("/comments/view/id/{$id}"));
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
