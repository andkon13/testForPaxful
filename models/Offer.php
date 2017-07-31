<?php
/**
 * Created by PhpStorm.
 * User: andkon
 * Date: 30.07.17
 * Time: 0:34
 */

namespace models;

use classes\ConstructTrait;
use classes\Model;
use classes\ModelInterface;

/**
 * Class Offer
 *
 * @package models
 */
class Offer extends Model implements ModelInterface
{
    public $id;
    public $user_id;
    public $type;
    public $pament_method_id;
    public $min;
    public $max;
    public $currency_id;
    public $margin;

    private $realFields = [
        'id',
        'user_id',
        'type',
        'pament_method_id',
        'min',
        'max',
        'currency_id',
        'margin',
    ];

    /**
     * @return bool
     */
    public function validate(): bool
    {
        foreach ($this->realFields as $realField) {
            if (!$this->realFields) {
                $this->errors[$realField] = $realField . ' is required';
            }
        }

        return 0 === count($this->errors);
    }
}
