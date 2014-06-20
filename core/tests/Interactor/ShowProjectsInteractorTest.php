<?php

namespace Metrics\Core\Interactor;

use Metrics\Core\Entity\Project;
use Metrics\Core\Presenter\GenericArrayPresenter;
use Metrics\Core\Repository\ProjectRepositoryMock;

class ShowProjectsInteractorTest extends \PHPUnit_Framework_TestCase
{
    public function testFetchesAllProjects()
    {
        $projects = [
            new Project(),
            new Project()
        ];
        $presenter = new GenericArrayPresenter();
        $repo = new ProjectRepositoryMock();
        $repo->projects = $projects;

        $interactor = new ShowProjectsInteractor($repo, $presenter);
        $this->assertEquals(
            $projects,
            $interactor->execute()
        );
    }
}
