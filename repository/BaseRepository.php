<?php
/**
 * Created by PhpStorm.
 * User: andkon
 * Date: 29.07.17
 * Time: 19:40
 */

namespace repository;

use classes\App;
use classes\ConstructTrait;
use classes\ModelInterface;
use classes\RepositoryInterface;

/**
 * Class BaseRepository
 *
 * @package repository
 */
class BaseRepository implements RepositoryInterface
{
    use ConstructTrait;

    protected $modelClass;
    public $table;

    /**
     * @param int $id
     *
     * @return ModelInterface
     */
    public function getById(int $id): ModelInterface
    {
        $models = $this->getByParams(['id' => $id], null, 1);

        return array_pop($models);
    }

    /**
     * @param array  $params
     * @param string $order
     * @param string $limit
     *
     * @return array
     */
    public function getByParams(array $params, $order = null, $limit = null): array
    {
        $res = App::getInstance()->db->select($this->table, $params, '*', $order, $limit);

        return $res->fetchAll(\PDO::FETCH_CLASS, $this->modelClass);
    }

    /**
     * @param null $order
     * @param null $limit
     *
     * @return array
     */
    public function getAll($order = null, $limit = null): array
    {
        $models = $this->getByParams([], $order, $limit);

        return $models;
    }

    /**
     * @param ModelInterface $model
     *
     * @return bool
     */
    public function save(ModelInterface $model): bool
    {
        if ($model->getId()) {
            return App::getInstance()->db->update($this->table, $model->getAttribs(), ['id' => $model->getId()]);
        }

        $id = App::getInstance()->db->insert($this->table, $model->getAttribs());
        if ($id) {
            $model->setId((int)$id);
        }

        return (bool)$id;
    }
}