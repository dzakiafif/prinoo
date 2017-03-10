<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 09/03/17
 * Time: 16:52
 */

namespace Komal\prinoo\Domain\Entity;
use Pentagonal\PhPass\PasswordHash;

/**
 * Class User
 * @package Komal\Prinoo\Domain\Entity
 * @Entity(repositoryClass="Komal\prinoo\Domain\Repository\DoctrineUserRepository")
 * @Table(name="users")
 * @HasLifecycleCallbacks
 */
class User
{
    /**
     * @Id
     * @Column(type="integer",nullable=false)
     * @var int
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string",length=255,nullable=false)
     * @var string
     */
    private $email;

    /**
     * @Column(type="string",name="first_name",length=255,nullable=false)
     * @var string
     */
    private $firstName;

    /**
     * @Column(type="string",name="last_name",length=255,nullable=false)
     * @var
     */
    private $lastName;

    /**
     * @Column(type="string",name="no_hp",length=12,nullable=false)
     * @var string  
     */
    private $noHp;

    /**
     * @Column(type="integer",name="jenis_kelamin",nullable=false)
     * @var string
     */
    private $jenisKelamin;

    /**
     * @Column(type="string",length=255,nullable=false)
     * @var string
     */
    private $alamat;

    /**
     * @Column(type="string",length=255,nullable=false)
     * @var string
     */
    private $password;

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
    
    public static function create($email,$firstName,$lastName,$noHp,$jenisKelamin,$alamat,$password)
    {

        $user = new User();
        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setNoHp($noHp);
        $user->setJenisKelamin($jenisKelamin);
        $user->setAlamat($alamat);
        $user->setPassword($password);
        $user->setCreatedAt(new \DateTime());
        $user->setUpdatedAt(new \DateTime());

        return $user;
        
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }



    /**
     * @return string
     */
    public function getNoHp()
    {
        return $this->noHp;
    }

    /**
     * @param string $noHp
     */
    public function setNoHp($noHp)
    {
        $this->noHp = $noHp;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $hash = new PasswordHash();
        $this->password = $hash->hash(md5($password));
    }

    public function setPasswordNonHash($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getJenisKelamin()
    {
        return $this->jenisKelamin;
    }

    /**
     * @param string $jenisKelamin
     */
    public function setJenisKelamin($jenisKelamin)
    {
        $this->jenisKelamin = $jenisKelamin;
    }

    /**
     * @return string
     */
    public function getAlamat()
    {
        return $this->alamat;
    }

    /**
     * @param string $alamat
     */
    public function setAlamat($alamat)
    {
        $this->alamat = $alamat;
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