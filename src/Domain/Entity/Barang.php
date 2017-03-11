<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 11/03/17
 * Time: 15:38
 */

namespace Komal\prinoo\Domain\Entity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Barang
 * @package Komal\prinoo\Domain\Entity
 * @Entity(repositoryClass="Komal\prinoo\Domain\Repository\DoctrineBarangRepository")
 * @HasLifecycleCallbacks
 * @Table(name="barang")
 */
class Barang
{

    /**
     * @Id
     * @Column(type="integer",nullable=false)
     * @var int
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string",name="nama_barang",length=120,nullable=false)
     * @var string
     */
    private $namaBarang;

    /**
     * @Column(type="text",nullable=false)
     * @var string
     */
    private $description;

    /**
     * @Column(type="string",name="barang_property",length=255,nullable=false)
     * @var string
     */
    private $barangProperty;

    /**
     * @Column(type="integer",name="is_top",nullable=true)
     * @var int
     */
    private $isTop;

    /**
     * @Column(type="datetime",name="created_at",nullable=false)
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @Column(type="datetime",name="updated_at",nullable=false)
     * @var \DateTime
     */
    private $updatedAt;

    public static function create($namaBarang,$description,$barangProperty)
    {

//        $barangProperty = md5(uniqid()) . '.' .$file->guessExtension();

        $barang = new Barang();
        $barang->setNamaBarang($namaBarang);
        $barang->setDescription($description);
        $barang->setBarangProperty($barangProperty);
        $barang->setIsTop(0);
        $barang->setCreatedAt(new \DateTime());
        $barang->setUpdatedAt(new \DateTime());

        return $barang;

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
    public function getNamaBarang()
    {
        return $this->namaBarang;
    }

    /**
     * @param string $namaBarang
     */
    public function setNamaBarang($namaBarang)
    {
        $this->namaBarang = $namaBarang;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getBarangProperty()
    {
        return $this->barangProperty;
    }

    /**
     * @param string $barangProperty
     */
    public function setBarangProperty($barangProperty)
    {
        $this->barangProperty = $barangProperty;
    }

    /**
     * @return int
     */
    public function getIsTop()
    {
        return $this->isTop;
    }

    /**
     * @param int $isTop
     */
    public function setIsTop($isTop)
    {
        $this->isTop = $isTop;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}