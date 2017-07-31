<?php

return [
    'db'                      => [
        'class'     => \classes\Db::class,
        'host'      => 'localhost',
        'dbname'    => 'test',
        'user'      => 'root',
        'pass'      => '123',
        'character' => 'utf8',
    ],
    'urlResolver'             => [
        'class' => \classes\UrlResolver::class,
        'rules' => [
            '/user/signin' => [\controllers\UserController::class, 'signin'],
            '/user/logout' => [\controllers\UserController::class, 'logout'],
            '/user/login'  => [\controllers\UserController::class, 'login'],
        ]
    ],
    'security'                => [
        'class' => \classes\Security::class,
        'salt'  => '34kj32432^*&&^jhjk',
    ],
    'userRepository'          => [
        'class'      => \repository\BaseRepository::class,
        'table'      => 'users',
        'modelClass' => \models\User::class
    ],
    'paymentMethodRepository' => [
        'class'      => \repository\BaseRepository::class,
        'table'      => 'payment_methods',
        'modelClass' => \models\PaymentMethod::class
    ],
    'offerRepository'         => [
        'class'      => \repository\OfferRepository::class,
        'table'      => 'offers',
        'modelClass' => \models\Offer::class,
    ],
    'currencyRepository'      => [
        'class'      => \repository\BaseRepository::class,
        'table'      => 'currencies',
        'modelClass' => \models\Currency::class,
    ]
];
