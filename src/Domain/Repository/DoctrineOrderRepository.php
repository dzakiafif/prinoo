<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 11/03/17
 * Time: 1:17
 */

namespace Komal\prinoo\Domain\Repository;


use Doctrine\ORM\EntityRepository;
use Komal\prinoo\Domain\Contracts\Repository\OrderRepositoryInterface;
use Komal\prinoo\Domain\Entity\Order;

class DoctrineOrderRepository extends EntityRepository implements OrderRepositoryInterface
{


    /**
     * @param $id
     * @return Order
     */
    public function findById($id)
    {
        return $this->find($id);
        // TODO: Implement findById() method.
    }

    /**
     * @param $userId
     * @return Order
     */
    public function findByUserId($userId)
    {
        return $this->findOneBy(['userId'=>$userId]);
        // TODO: Implement findByUserId() method.
    }

    /**
     * @param $namaProduk
     * @return Order
     */
    public function findByNamaProduk($namaProduk)
    {
        // TODO: Implement findByNamaProduk() method.
    }
}