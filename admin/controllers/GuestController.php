<?php

namespace admin\controllers;

use components\web\Controller;
use components\web\User as UserComponent;
use helpers\Request;
use models\User;

/**
 * Class GuestController
 * @package web\controllers
 */
class GuestController extends Controller
{
    /**
     * @return string
     */
    public function actionLogin()
    {
        return $this->render('login');
    }

    public function actionAuthorize()
    {
        $model = (new User())->find(['email' => Request::post('email'), 'is_admin' => true]);
        if (empty($model)) {
            $this->getSession()->addFlash('error', 'Admin "' . Request::post('email') . '" is not exists');
            $this->redirect('/');
        }

        $model = current($model);
        /** @var User $model */
        if (!UserComponent::isValidPassword(Request::post('password'), $model->password)) {
            $this->getSession()->addFlash('error', 'Password for admin "' . Request::post('email') . '" is incorrect');
            $this->redirect('/');
        }

        $this->getUser()->authenticate($model);

        $this->redirect('/');
    }

    public function actionLogOut()
    {
        $this->getUser()->logOut();

        $this->redirect('/');
    }
}
