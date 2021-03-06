<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 10/03/17
 * Time: 23:54
 */

namespace Komal\prinoo\Domain\Entity;

/**
 * Class Order
 * @package Komal\prinoo\Domain\Entity
 * @Entity(repositoryClass="Komal\prinoo\Domain\Repository\DoctrineOrderRepository")
 * @Table(name="order")
 * @HasLifecycleCallbacks
 */
class Order
{
    /**
     * @Id
     * @Column(type="integer",nullable=false)
     * @var int
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string",name="nama_produk",length=255,nullable=false)
     * @var string
     */
    private $namaProduk;

    /**
     * @ManyToOne(targetEntity="Komal\prinoo\Domain\Entity\User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     * @var int
     */
    private $userId;

    /**
     * @ManyToOne(targetEntity="Komal\prinoo\Domain\Entity\Barang")
     * @JoinColumn(name="jenis_produk", referencedColumnName="id")
     * @var int
     */
    private $jenisProduk;

    /**
     * @Column(type="string",length=100,nullable=false)
     * @var string
     */
    private $bahan;

    /**
     * @Column(type="integer",name="ukuran_panjang",nullable=false)
     * @var int
     */
    private $ukuranPanjang;

    /**
     * @Column(type="integer",name="ukuran_lebar",nullable=false)
     * @var int
     */
    private $ukuranLebar;

    /**
     * @Column(type="integer",name="jumlah_barang",nullable=false)
     * @var int
     */
    private $jumlahBarang;

    /**
     * @Column(type="integer",nullable=false)
     * @var int
     */
    private $kualitas;

    /**
     * @Column(type="string",name="order_property",nullable=false)
     * @var string
     */
    private $orderProperty;

    /**
     * @Column(type="integer",name="jumlah_harga",nullable=false)
     * @var
     */
    private $jumlahHarga;

    public static function create($namaProduk,User $userId,Barang $jenisProduk,$bahan,$ukuranPanjang,$ukuranLebar,$jumlahBarang,$kualitas,$orderProperty,$jumlahHarga)
    {
        $order = new Order();
        $order->setNamaProduk($namaProduk);
        $order->setUserId($userId);
        $order->setJenisProduk($jenisProduk);
        $order->setBahan($bahan);
        $order->setUkuranPanjang($ukuranPanjang);
        $order->setUkuranLebar($ukuranLebar);
        $order->setJumlahBarang($jumlahBarang);
        $order->setKualitas($kualitas);
        $order->setOrderProperty($orderProperty);
        $order->setJumlahHarga($jumlahHarga);
        
        return $order;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNamaProduk()
    {
        return $this->namaProduk;
    }

    /**
     * @param string $namaProduk
     */
    public function setNamaProduk($namaProduk)
    {
        $this->namaProduk = $namaProduk;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(User $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getJenisProduk()
    {
        return $this->jenisProduk;
    }

    /**
     * @param int $jenisProduk
     */
    public function setJenisProduk(Barang $jenisProduk)
    {
        $this->jenisProduk = $jenisProduk;
    }

    /**
     * @return string
     */
    public function getBahan()
    {
        return $this->bahan;
    }

    /**
     * @param string $bahan
     */
    public function setBahan($bahan)
    {
        $this->bahan = $bahan;
    }

    /**
     * @return int
     */
    public function getUkuranPanjang()
    {
        return $this->ukuranPanjang;
    }

    /**
     * @param int $ukuranPanjang
     */
    public function setUkuranPanjang($ukuranPanjang)
    {
        $this->ukuranPanjang = $ukuranPanjang;
    }

    /**
     * @return int
     */
    public function getUkuranLebar()
    {
        return $this->ukuranLebar;
    }

    /**
     * @param int $ukuranLebar
     */
    public function setUkuranLebar($ukuranLebar)
    {
        $this->ukuranLebar = $ukuranLebar;
    }

    /**
     * @return int
     */
    public function getJumlahBarang()
    {
        return $this->jumlahBarang;
    }

    /**
     * @param int $jumlahBarang
     */
    public function setJumlahBarang($jumlahBarang)
    {
        $this->jumlahBarang = $jumlahBarang;
    }

    /**
     * @return int
     */
    public function getKualitas()
    {
        return $this->kualitas;
    }

    /**
     * @param int $kualitas
     */
    public function setKualitas($kualitas)
    {
        $this->kualitas = $kualitas;
    }

    /**
     * @return string
     */
    public function getOrderProperty()
    {
        return $this->orderProperty;
    }

    /**
     * @param string $orderProperty
     */
    public function setOrderProperty($orderProperty)
    {
        $this->orderProperty = $orderProperty;
    }

    /**
     * @return mixed
     */
    public function getJumlahHarga()
    {
        return $this->jumlahHarga;
    }

    /**
     * @param mixed $jumlahHarga
     */
    public function setJumlahHarga($jumlahHarga)
    {
        $this->jumlahHarga = $jumlahHarga;
    }

}