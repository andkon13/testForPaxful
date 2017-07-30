<?php
/**
 * Created by PhpStorm.
 * User: andkon
 * Date: 29.07.17
 * Time: 18:22
 */

namespace models;

use classes\App;
use classes\ConstructTrait;
use classes\Model;
use classes\ModelInterface;

/**
 * Class User
 *
 * @package models
 */
class User extends Model implements ModelInterface
{
    use ConstructTrait;

    public $username;
    public $fullname;
    public $amount;
    protected $password;

    /**
     * @param mixed $password
     */
    public function setPassword(string $password)
    {
        $this->password = App::getInstance()->security->cryptPassword($password);
    }

    /**
     * @param $password
     *
     * @return bool
     */
    public function checkPassword(string $password): bool
    {
        return $this->password === App::getInstance()->security->cryptPassword($password);
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        $this->errors = [];
        foreach (['username', 'fullname', 'password'] as $field) {
            if (empty(trim($this->$field))) {
                $this->errors[$field] = $field . ' is required!';
            }
        }

        return 0 === count($this->errors);
    }

    /**
     * @return array
     */
    public function getAttribs(): array
    {
        $attrib           = parent::getAttribs();
        $attrib['amount'] = $this->amount ?? 0;

        return $attrib;
    }
}
