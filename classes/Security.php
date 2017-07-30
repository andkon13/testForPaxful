<?php
/**
 * Created by PhpStorm.
 * User: andkon
 * Date: 29.07.17
 * Time: 18:24
 */

namespace classes;

use interfaces\ComponentInterface;

/**
 * Class Security
 *
 * @package classes
 */
class Security implements ComponentInterface
{
    use ConstructTrait;

    private $salt;

    /**
     * @param string $password
     *
     * @return string
     */
    public function cryptPassword($password)
    {
        // md5 is not security, bit this only test...
        return md5($password . $this->salt);
    }
}