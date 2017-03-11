<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 11/03/17
 * Time: 16:15
 */

namespace Komal\prinoo\Domain\Repository;


use Doctrine\ORM\EntityRepository;
use Komal\prinoo\Domain\Contracts\Repository\BarangRepositoryInterface;
use Komal\prinoo\Domain\Entity\Barang;

class DoctrineBarangRepository extends EntityRepository implements BarangRepositoryInterface
{

    /**
     * @param $id
     * @return Barang
     */
    public function findById($id)
    {
        return $this->find($id);
        // TODO: Implement findById() method.
    }

    /**
     * @param $namaBarang
     * @return Barang
     */
    public function findByNamaBarang($namaBarang)
    {
        return $this->findOneBy(['namaBarang'=>$namaBarang]);
        // TODO: Implement findByNamaBarang() method.
    }
}