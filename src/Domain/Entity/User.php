<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 09/03/17
 * Time: 16:52
 */

namespace Komal\prinoo\Domain\Entity;
use Faker\Factory;

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
     * @Column(type="integer",nullable=true)
     * @var int
     */
    private $role;

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
     * @Column(type="string",length=255,nullable=true)
     * @var string
     */
    private $token;

    /**
     * @Column(type="integer",nullable=false)
     * @var
     */
    private $status;

    /**
     * @Column(type="string",length=255,nullable=true)
     * @var string
     */
    private $userProperty;

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
        $user->setRole(2);
        $user->setJenisKelamin($jenisKelamin);
        $user->setAlamat($alamat);
        $user->setPassword($password);
        $user->setToken(sha1($email));
        $user->setStatus(0);
        $user->setCreatedAt(new \DateTime());
        $user->setUpdatedAt(new \DateTime());

        return $user;
        
    }

    public static function createDummy()
    {
        $data = new User();

        $faker = Factory::create();
        $email = $faker->email;

        $data->setEmail($email);
        $data->setFirstName($faker->firstName);
        $data->setLastName($faker->lastName);
        $data->setNoHp($faker->phoneNumber);
        $data->setRole(2);
        $data->setJenisKelamin(0);
        $data->setAlamat($faker->address);
        $data->setPassword($faker->password);
        $data->setToken(sha1($email));
        $data->setStatus(0);
        $data->setCreatedAt(new \DateTime());
        $data->setUpdatedAt(new \DateTime());

        return $data;
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
     * @return int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param int $role
     */
    public function setRole($role)
    {
        $this->role = $role;
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
//        $hash = new PasswordHash();
        $this->password = md5($password);
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
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getUserProperty()
    {
        return $this->userProperty;
    }

    /**
     * @param string $userProperty
     */
    public function setUserProperty($userProperty)
    {
        $this->userProperty = $userProperty;
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