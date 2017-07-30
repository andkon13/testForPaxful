<?php
/**
 * Created by PhpStorm.
 * User: andkon
 * Date: 30.07.17
 * Time: 14:30
 */

namespace models;

use classes\ConstructTrait;
use classes\Model;
use classes\ModelInterface;

/**
 * Class PaymentMethod
 *
 * @package models
 */
class PaymentMethod extends Model implements ModelInterface
{
    use ConstructTrait;

    public $group_id;
    public $name;

    /**
     * @return bool
     */
    public function validate(): bool
    {
        if (empty($this->group_id)) {
            $this->errors['group_id'] = 'GroupId is required';
        }

        if (empty($this->name)) {
            $this->errors['name'] = 'Name is required';
        }

        return 0 === count($this->errors);
    }
}
