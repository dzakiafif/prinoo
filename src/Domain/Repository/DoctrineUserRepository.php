<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 09/03/17
 * Time: 16:57
 */

namespace Komal\prinoo\Domain\Repository;


use Komal\prinoo\Domain\Contracts\Repository\UserRepositoryInterface;
use Komal\prinoo\Domain\Entity\User;

class DoctrineUserRepository implements UserRepositoryInterface
{

    /**
     * @param $id
     * @return User
     */
    public function findById($id)
    {
        // TODO: Implement findById() method.
    }

    /**
     * @param $email
     * @return User
     */
    public function findByEmail($email)
    {
        // TODO: Implement findByEmail() method.
    }
}