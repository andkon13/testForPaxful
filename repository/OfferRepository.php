<?php
/**
 * Created by PhpStorm.
 * User: andkon
 * Date: 30.07.17
 * Time: 1:07
 */

namespace repository;

use classes\App;
use classes\RepositoryInterface;

/**
 * Class OfferRepository
 *
 * @package repository
 */
class OfferRepository extends BaseRepository implements RepositoryInterface
{
    /**
     * @return array
     */
    public function getList()
    {
        $app = App::getInstance();
        $sql = 'SELECT * FROM ' . $this->table . ' o '
            . 'JOIN `' . $app->userRepository->table . '` u ON o.user_id=u.id';

        $res = $app->db->getResult($sql);

        return $res->fetchAll();
    }
}
