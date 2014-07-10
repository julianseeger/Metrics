<?php

namespace Metrics\Core\Repository;

use Metrics\Core\Entity\User;
use Metrics\Core\Repository\Exception\UserNotFoundException;

interface UserRepository
{
    /**
     * @param $name
     * @param $password
     * @throws UserNotFoundException
     * @return User
     */
    public function getUser($name, $password);

    /**
     * @param User $user
     */
    public function addUser(User $user);
}
