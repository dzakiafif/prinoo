<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 11/03/17
 * Time: 13:09
 */

namespace Komal\prinoo\Domain\Services;

use Komal\prinoo\Domain\Entity\User;
class UserPasswordMatcher
{
    private $rawPassword;

    private $user;

    public function __construct($rawPassword, User $user)
    {
        $this->rawPassword = $rawPassword;
        $this->user = $user;
    }
    public function match()
    {
        return password_verify($this->rawPassword, $this->user->getPassword());
    }

}