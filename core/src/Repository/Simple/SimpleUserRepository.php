<?php

namespace Metrics\Core\Repository\Simple;

use Metrics\Core\Entity\User;
use Metrics\Core\Repository\Exception\UserNotFoundException;
use Metrics\Core\Repository\UserRepository;

class SimpleUserRepository implements UserRepository
{
    /** @var User[] */
    private $users = [];

    public function getUser($name, $password)
    {
        if (isset($this->users[$name])) {
            $matchUser = $this->users[$name];
            if ($matchUser->getPassword() === $password) {
                return $matchUser;
            }
        }
        throw new UserNotFoundException();
    }

    /**
     * @param User $user
     */
    public function addUser(User $user)
    {
        $this->users[$user->getName()] = $user;
    }
}
