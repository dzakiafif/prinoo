<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 09/03/17
 * Time: 16:57
 */

namespace Komal\prinoo\Domain\Repository;


use Doctrine\ORM\EntityRepository;
use Komal\prinoo\Domain\Contracts\Repository\UserRepositoryInterface;
use Komal\prinoo\Domain\Entity\User;

class DoctrineUserRepository extends EntityRepository implements UserRepositoryInterface
{

    /**
     * @param $id
     * @return User
     */
    public function findById($id)
    {
        return $this->find($id);
        // TODO: Implement findById() method.
    }

    /**
     * @param $email
     * @return User
     */
    public function findByEmail($email)
    {
        return $this->findOneBy(['email'=>$email]);
        // TODO: Implement findByEmail() method.
    }

    /**
     * @param $token
     * @return User
     */
    public function findByToken($token)
    {
        return $this->findOneBy(['token'=>$token]);
        // TODO: Implement findByToken() method.
    }
}