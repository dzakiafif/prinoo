<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 11/03/17
 * Time: 16:13
 */

namespace Komal\prinoo\Domain\Contracts\Repository;

use Komal\prinoo\Domain\Entity\Barang;
interface BarangRepositoryInterface
{

    /**
     * @param $id
     * @return Barang
     */
    public function findById($id);

    /**
     * @param $namaBarang
     * @return Barang
     */
    public function findByNamaBarang($namaBarang);

}