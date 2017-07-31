<?php
/**
 * Created by PhpStorm.
 * User: andkon
 * Date: 29.07.17
 * Time: 0:39
 */

namespace controllers;

use classes\App;
use classes\Controller;

/**
 * Class DefaultController
 *
 * @package controllers
 */
class DefaultController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $offers = App::getInstance()->offerRepository->getList();
        $usersId  = array_column($offers, 'user_id');
        if (count($usersId)) {
            $users = [];
            foreach (App::getInstance()->userRepository->getByParams(['id' => $usersId]) as $user) {
                $users[$user->getId()] = $user;
            }
        }

        $payMethods = [];
        foreach (App::getInstance()->paymentMethodRepository->getAll() as $payMethod) {
            $payMethods[$payMethod->getId()] = $payMethod;
        }

        return $this->render('index', compact('offers', 'users', 'payMethods'));
    }
}
