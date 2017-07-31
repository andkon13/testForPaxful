<?php

namespace classes;

use Exception;
use interfaces\ComponentInterface;
use models\User;
use repository\BaseRepository;
use repository\OfferRepository;

/**
 * Class App
 *
 * @property UrlResolver     $urlResolver
 * @property Security        $security
 * @property Db              $db
 * @property BaseRepository  $userRepository
 * @property OfferRepository $offerRepository
 * @property BaseRepository  $paymentMethodRepository
 * @property BaseRepository  $currencyRepository
 */
class App
{
    /** @var  static */
    static private $instance;
    /** @var bool */
    static private $newInstance = false;
    protected $config = [];
    protected $components = [];

    /**
     * @inheritdoc
     * @throws Exception
     */
    final public function __construct()
    {
        if (!self::$newInstance) {
            throw new Exception('Please use ' . __CLASS__ . "::getInstance");
        }
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->components)) {
            return $this->components[$name];
        }

        // simple DI realisation
        if (!($this->config[$name]['class'] ?? false)) {
            throw new \ErrorException("Please set component $name in config.");
        }

        $componentConfig = $this->config[$name];
        $component       = $componentConfig['class'];
        unset($componentConfig['class']);
        // if generated exception - this catch in self::run()
        $component = new $component($componentConfig);
        if (!$component instanceof ComponentInterface) {
            throw new \Exception('Component must by implements of ComponentInterface');
        }

        $this->components[$name] = $component;

        return $component;
    }

    /**
     * @param $config
     *
     * @return void
     */
    public static function run($config)
    {
        $instance = self::getInstance();
        $instance->setConfig($config);
        $action = $instance->urlResolver->resolve();
        if (count($action) && class_exists($action['class'])) {
            $controllerName = $action['class'];
            $actionName     = $action['action'];
            try {
                /** @var Controller $controller */
                $controller = new $controllerName();
                $content    = $controller->$actionName();
                echo $controller->renderLayout($content);
            } catch (Exception $e) {
                http_response_code(500);
                var_dump([$e, $_SERVER, ($_SESSION ?? [])]);
            }
        } else {
            http_response_code(404);
        }
    }

    /**
     * @return App
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$newInstance = true;
            self::$instance    = new App();
            self::$newInstance = false;
        }

        return self::$instance;
    }

    /**
     * @param array $config
     */
    protected function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param User $model
     *
     * @return bool
     */
    public function login(User $model)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION['userId'] = $model->getId();

        return true;
    }

    /**
     * @return bool
     */
    public function isGuest(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $hash = $_COOKIE['autoLogin'] ?? null;
        if ($hash) {
            $userId = $this->db->select(
                $this->userRepository->table,
                ['hash' => $hash],
                'id, md5(concat(id, "' . $this->security->getSalt() . '") as hash)'
            )->fetchColumn();
            if (count($userId)) {
                $_SESSION['userId'] = $userId[0];
            }
        }

        return (bool)!($_SESSION['userId'] ?? false);
    }

    /**
     * @return bool
     */
    public function logout()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        return session_destroy();
    }
}
