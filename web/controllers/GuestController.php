<?php

namespace web\controllers;

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
        $model = (new User())->find(['email' => Request::post('email')]);
        if (empty($model)) {
            $this->getSession()->addFlash('error', 'User "' . Request::post('email') . '" is not exists');
            $this->redirect('/');
        }

        $model = current($model);
        /** @var User $model */
        if (!UserComponent::isValidPassword(Request::post('password'), $model->password)) {
            $this->getSession()->addFlash('error', 'Password for user "' . Request::post('email') . '" is incorrect');
            $this->redirect('/');
        }

        $this->getUser()->authenticate($model);

        $this->redirect('/');
    }

    /**
     * @return string
     */
    public function actionRegister()
    {
        return $this->render('register');
    }

    public function actionCreateAccount()
    {
        $model = new User();
        $existed = $model->find(['email' => Request::post('email')]);
        if ($existed) {
            $this->getSession()->addFlash('error', 'User "' . Request::post('email') . '" is already exists');
            $this->redirect('/guest/register');
        }

        if (Request::post('password') == Request::post('repeat_password')) {
            $model->load(['password' => UserComponent::generatePasswordHash(Request::post('password'))]);
        } else {
            $this->getSession()->addFlash('error', 'Passwords are not equal');
            $this->redirect('/guest/register');
        }

        $model->load(['name' => Request::post('name'), 'email' => Request::post('email'), 'is_admin' => 0]);
        $model->save();

        $this->getUser()->authenticate($model);

        $this->redirect('/');
    }

    public function actionLogOut()
    {
        $this->getUser()->logOut();

        $this->redirect('/');
    }
}
