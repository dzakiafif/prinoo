<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 11/03/17
 * Time: 1:15
 */

namespace Komal\prinoo\Domain\Contracts\Repository;

use Komal\prinoo\Domain\Entity\Order;
interface OrderRepositoryInterface
{
    /**
     * @param $id
     * @return Order
     */
    public function findById($id);

    /**
     * @param $userId
     * @return Order
     */
    public function findByUserId($userId);

    /**
     * @param $namaProduk
     * @return Order
     */
    public function findByNamaProduk($namaProduk);

}