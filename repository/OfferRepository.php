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
        $sql = 'SELECT *, margin * 3000 * c.rate AS price, margin * c.rate * min as cost'
        .' FROM ' . $this->table . ' o '
            . 'JOIN `' . $app->userRepository->table . '` u ON o.user_id=u.id'
            . ' JOIN `' . $app->currencyRepository->table . '` c ON o.currency_id=c.id';

        $res = $app->db->getResult($sql);

        return $res->fetchAll(\PDO::FETCH_ASSOC);
    }
}
