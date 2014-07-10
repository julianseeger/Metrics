<?php

namespace Metrics\Core\Interactor;

use Metrics\Core\Entity\User;
use Metrics\Core\Interactor\Exception\AuthenticationRequiredException;
use Metrics\Core\Repository\UserRepository;

class AuthenticateInteractor
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param $username
     * @param $password
     * @throws Exception\AuthenticationRequiredException
     * @return User
     */
    public function execute($username, $password)
    {
        try {
            return $this->userRepository->getUser($username, $password);
        } catch (\Exception $e) {
            throw new AuthenticationRequiredException("Authentication failed", 0, $e);
        }
    }
}
