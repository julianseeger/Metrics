<?php

namespace Metrics\Core\Interactor;

use Metrics\Core\Entity\User;
use Metrics\Core\Repository\Simple\SimpleUserRepository;
use Metrics\Core\Repository\UserRepository;

class AuthenticateInteractorTest extends \PHPUnit_Framework_TestCase
{
    /** @var UserRepository */
    private $userRepository;

    /** @var AuthenticateInteractor */
    private $interactor;

    /**
     * @expectedException \Metrics\Core\Interactor\Exception\AuthenticationRequiredException
     */
    public function testThrowsAuthenticationRequiredExceptionIfUserIsNotFound()
    {
        $this->interactor->execute('some', 'user');
    }

    public function testReturnsUserOnSuccess()
    {
        $user = new User('some', 'user');
        $this->userRepository->addUser($user);
        $result = $this->interactor->execute('some', 'user');
        $this->assertEquals($user->getName(), $result->getName());
        $this->assertEquals($user->getPassword(), $result->getPassword());
    }

    protected function setUp()
    {
        parent::setUp();
        $this->userRepository = new SimpleUserRepository();
        $this->interactor = new AuthenticateInteractor($this->userRepository);
    }
}
