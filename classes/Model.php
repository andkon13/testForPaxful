<?php
/**
 * Created by PhpStorm.
 * User: andkon
 * Date: 30.07.17
 * Time: 0:36
 */

namespace classes;

/**
 * Class Model
 *
 * @property int $id
 * @package classes
 */
abstract class Model
{
    protected $id;
    protected $errors = [];

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function getAttribs()
    {
        $fields = get_object_vars($this);
        unset($fields['errors']);

        return $fields;
    }
}
