<?php

namespace Metrics\Core\Interactor;

use Metrics\Core\Entity\Project;
use Metrics\Core\Repository\ProjectRepositoryMock;

class AddProjectInteractorTest extends \PHPUnit_Framework_TestCase
{
    public function testAddsProjectToRepository()
    {
        $name = 'testname';
        $repo = new ProjectRepositoryMock();
        $interactor = new AddProjectInteractor($repo);

        $this->assertEmpty($repo->findAll());

        $interactor->execute($name);

        $projects = $repo->findAll();
        $this->assertEquals(1, count($projects));
        /** @var Project $project */
        $project = $repo->findOne($name);
        $this->assertInstanceOf('\\Metrics\\Core\\Entity\\Project', $project);
        $this->assertEquals($name, $project->getName());
    }
}
