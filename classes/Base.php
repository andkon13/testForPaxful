<?php
/**
 * Created by PhpStorm.
 * User: andkon
 * Date: 20.12.14
 * Time: 12:52
 */

namespace classes;

/**
 * Class Base
 *
 * @package classes
 * @property $id
 */
abstract class Base
{
    /** @var  string */
    protected static $tableName;
    protected static $fields;
    protected $errors = [];

    /**
     * @param int $id
     *
     * @return Base
     */
    public static function findById($id)
    {
        $result = Db::getInstance()->select(static::$tableName, ['id' => $id]);
        $model  = $result->fetchObject(static::className());
        if ($model) {
            $model->afterFind();
        }

        return $model;
    }

    /**
     * Возвращает класс
     *
     * @return string
     */
    public static function className()
    {
        return get_called_class();
    }

    /**
     * Возвращает имя таблицы
     *
     * @return string
     */
    public static function getTableName()
    {
        return static::$tableName;
    }

    /**
     * @param $attributes
     *
     * @return Base[]
     */
    public static function findByAttributes($attributes)
    {
        $models = Db::getInstance()->select(static::$tableName, $attributes)->fetchAll(\PDO::FETCH_CLASS, static::className());

        return $models;
    }

    /**
     * @param string $query
     * @param array  $param
     *
     * @return Base[]
     */
    public static function findBySql($query, $param = [])
    {
        return Db::getInstance()->getResult($query, $param)->fetchAll(\PDO::FETCH_CLASS, static::className());
    }

    /**
     * Действие после быборки из базы
     *
     * @return void
     */
    public function afterFind()
    {
    }

    /**
     * @return bool|string
     */
    public function save()
    {
        $save = false;
        if ($this->validate()) {
            $db = Db::getInstance();
            if ($this->id) {
                $save = $db->update(static::$tableName, $this->getAttributes(), ['id' => $this->id]);
            } else {
                $save = $db->insert(static::$tableName, $this->getAttributes());
                if ($save) {
                    $this->id = $save;
                }
            }
        }

        return $save;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        $vars = $this->getFields();
        if (empty($this->id) && in_array('created', $vars)) {
            $this->created = date('Y-m-d H:i:s');
        }

        if ($this->id && in_array('updated', $vars)) {
            $this->updated = date('Y-m-d H:i:s');
        }

        return !$this->hasErrors();
    }

    /**
     * @return array
     */
    private function getFields()
    {
        if (!static::$fields) {
            $query          = "SHOW COLUMNS FROM `" . static::$tableName . "`";
            $res            = Db::getInstance()->getResult($query);
            $res            = $res->fetchAll(\PDO::FETCH_ASSOC);
            static::$fields = [];
            foreach ($res as $row) {
                static::$fields[] = $row['Field'];
            }
        }

        return static::$fields;
    }

    /**
     * Проверяет есть ли ошибки
     *
     * @param null|string $field
     *
     * @return bool
     */
    public function hasErrors($field = null)
    {
        if ($field) {
            return (array_key_exists($field, $this->errors) && !empty($this->errors[$field]));
        } else {
            foreach ($this->errors as $array) {
                if (!empty($array)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        $attributes = [];
        $fields     = $this->getFields();
        foreach ($fields as $field) {
            $attributes[$field] = $this->$field;
        }

        return $attributes;
    }

    /**
     * @param null $field
     *
     * @return array|string
     */
    public function getErrors($field = null)
    {
        if (!$field) {
            return $this->errors;
        } else {
            if (!empty($this->errors[$field])) {
                return implode($this->errors[$field]);
            }
        }

        return '';
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws \Exception
     */
    function __get($name)
    {
        $methodName = 'get' . ucfirst($name);
        if (method_exists($this, $methodName)) {
            return $this->$methodName();
        } elseif (in_array($name, $this->getFields())) {
            return null;
        }

        throw new \Exception('property ' . $name . ' not exist in ' . get_called_class());
    }

    /**
     * @param $attributes
     *
     * @return $this
     */
    public function setAttributes($attributes)
    {
        $fields = $this->getFields();
        foreach ($attributes as $field => $val) {
            if (in_array($field, $fields)) {
                $this->$field = $val;
            }
        }

        return $this;
    }

    /**
     * @param string $field
     * @param string $error
     *
     * @return void
     */
    public function addError($field, $error)
    {
        if (!array_key_exists($field, $this->errors)) {
            $this->errors[$field] = [];
        }

        $this->errors[$field][] = $error;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach ($this->getFields() as $field) {
            $array[$field] = $this->$field;
        }

        return $array;
    }

    /**
     * @return bool
     */
    public function delete()
    {
        $table = static::$tableName;

        return Db::getInstance()->execute("delete from $table where id=:id", [':id' => $this->id]);
    }
}
