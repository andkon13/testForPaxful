<?php
/**
 * Created by PhpStorm.
 * User: andkon
 * Date: 29.07.17
 * Time: 0:40
 */

namespace classes;

use Exception;

/**
 * Class Controller
 *
 * @package classes
 */
abstract class Controller
{
    /**
     * @param       $view
     * @param array $vars
     *
     * @return string
     * @throws Exception
     */
    protected function render($view, $vars = [])
    {
        $controllerId = '';
        if ($view !== 'layout') {
            $controllerId = $this->getId() . DIRECTORY_SEPARATOR;
        }

        $file = __DIR__ . DIRECTORY_SEPARATOR
            . '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR
            . $controllerId
            . $view . '.php';
        if (!file_exists($file)) {
            throw new Exception('View ' . $file . ' not found', 500);
        }

        ob_start();
        ob_implicit_flush(false);
        extract($vars, EXTR_OVERWRITE);
        require($file);

        return ob_get_clean();
    }

    /**
     * @param $link
     *
     * @return void
     */
    protected function redirect($link)
    {
        http_response_code(301);
        header("Location: $link");
        exit;
    }

    /**
     * @param $content
     *
     * @return string
     */
    public function renderLayout($content)
    {
        return $this->render('layout', compact('content'));
    }

    /**
     * @return array
     */
    protected function getPost()
    {
        //here may make validate post data
        return $_POST ?? [];
    }

    /**
     * @return string
     */
    private function getId()
    {
        $ref = new \ReflectionClass(static::class);

        return strtolower(str_replace('Controller', '', $ref->getShortName()));
    }
}
