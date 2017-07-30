<?php
/**
 * Created by PhpStorm.
 * User: andkon
 * Date: 29.07.17
 * Time: 18:17
 */

namespace controllers;

use classes\App;
use classes\Controller;
use models\User;

/**
 * Class UserController
 *
 * @package controllers
 */
class UserController extends Controller
{
    /**
     * @return string
     */
    public function actionSignin()
    {
        $post  = $this->getPost();
        $model = new User($post);
        if ($model->validate() && App::getInstance()->userRepository->save($model)) {
            App::getInstance()->login($model);
            if (($post['remember_me'] ?? false)) {
                setcookie('autoLogin', $model->getId(), (60 * 60 * 48));
            }

            $this->redirect('/');
        }

        return $this->render('signin', compact('model'));
    }

    public function actionLogout()
    {
        App::getInstance()->logout();
        $this->redirect('/');
    }

    /**
     * @return string
     */
    public function actionLogin()
    {
        $post = $this->getPost();
        if (($post['username'] ?? false) && ($post['password'] ?? false)) {
            $post['password'] = App::getInstance()->security->cryptPassword($post['password']);
            unset($post['Login']);
            $user = App::getInstance()->userRepository->getByParams($post, null, 1);
            if ($user) {
                App::getInstance()->login($user[0]);
                $this->redirect('/');
            }
        }

        return $this->render('login');
    }
}

