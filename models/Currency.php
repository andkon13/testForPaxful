<?php
/**
 * Created by PhpStorm.
 * User: andkon
 * Date: 31.07.17
 * Time: 23:24
 */

namespace models;

use classes\Model;
use classes\ModelInterface;

/**
 * Class Currency
 *
 * @package models
 */
class Currency extends Model implements ModelInterface
{
    /** @var  string */
    public $name;
    /** @var  float */
    public $rate;

    /**
     * @return bool
     */
    public function validate(): bool
    {
        $this->errors = [];
        if (empty($this->name)) {
            $this->errors['name'] = 'Name is required';
        }

        if (empty($this->rate)) {
            $this->errors['rate'] = 'Name is required';
        }

        return 0 === count($this->errors);
    }
}