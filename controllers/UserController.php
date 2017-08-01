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
        $model = new User();
        $model->setPassword($post['password'] ?? '');
        $model->amount = 5; //Every registered user gets complimentary 5 BTC
        if ($model->load($post) && $model->validate() && App::getInstance()->userRepository->save($model)) {
            App::getInstance()->login($model);
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
            /** @var User[] $user */
            $user = App::getInstance()
                ->userRepository
                ->getByParams(
                    [
                        'username' => $post['username'],
                        'password' => App::getInstance()->security->cryptPassword($post['password'])
                    ],
                    null,
                    1
                );
            if ($user) {
                $user = $user[0];
                App::getInstance()->login($user);
                if (($post['remember_me'] ?? false)) {
                    setcookie('autoLogin', App::getInstance()->security->cryptPassword($user->getId()), (60 * 60 * 48));
                }
                $this->redirect('/');
            }
        }

        return $this->render('login');
    }
}

