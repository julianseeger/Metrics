<?php

namespace Metrics\Core\Repository\Simple;

use Metrics\Core\Entity\User;

class SimpleUserRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Metrics\Core\Repository\Exception\UserNotFoundException
     */
    public function testGetUserThrowsExceptionIfUserDoesNotExist()
    {
        $repo = new SimpleUserRepository();
        $repo->getUser('does not', 'exist');
    }

    public function testAddUser()
    {
        $repo = new SimpleUserRepository();
        $user = new User('name', 'pass');

        $repo->addUser($user);

        $this->assertEquals($user, $repo->getUser('name', 'pass'));
    }
}
