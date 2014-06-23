<?php

namespace Metrics\Core\Interactor;

use Metrics\Core\Entity\Project;
use Metrics\Core\Entity\Version;
use Metrics\Core\Presenter\GenericArrayPresenter;
use Metrics\Core\Repository\ProjectRepositoryMock;
use Metrics\Core\Repository\VersionRepositoryMock;

class ShowVersionsInteractorTest extends \PHPUnit_Framework_TestCase
{
    public function testFetchesAllProjects()
    {
        $projectRepo = new ProjectRepositoryMock();
        $project = $projectRepo->create("a");

        $versionRepo = new VersionRepositoryMock();
        $version1 = $versionRepo->create($project, "0.1");
        $version2 = $versionRepo->create($project, "0.2");
        $presenter = new GenericArrayPresenter();

        $interactor = new ShowVersionsInteractor($versionRepo, $projectRepo, $presenter);
        $this->assertEquals(
            [$version1, $version2],
            $interactor->execute($project->getName())
        );
    }
}
