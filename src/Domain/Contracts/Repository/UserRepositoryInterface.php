<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 09/03/17
 * Time: 16:58
 */

namespace Komal\prinoo\Domain\Contracts\Repository;

use Komal\prinoo\Domain\Entity\User;

interface UserRepositoryInterface
{
    /**
     * @param $id
     * @return User
     */
    public function findById($id);

    /**
     * @param $email
     * @return User
     */
    public function findByEmail($email);

    /**
     * @param $token
     * @return User
     */
    public function findByToken($token);

}