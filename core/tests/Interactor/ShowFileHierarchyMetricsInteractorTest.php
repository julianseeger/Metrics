<?php

namespace Metrics\Core\Interactor;

use Metrics\Core\Entity\Project;
use Metrics\Core\Entity\Version;
use Metrics\Core\Presenter\ArrayBased\ArrayBasedShowFileHierarchyMetricsPresenter;
use Metrics\Core\Repository\FileVersionRepository;
use Metrics\Core\Repository\FileVersionRepositoryMock;
use Metrics\Core\Repository\MetricRepository;
use Metrics\Core\Repository\MetricRepositoryMock;
use Metrics\Core\Repository\ProjectRepository;
use Metrics\Core\Repository\ProjectRepositoryMock;
use Metrics\Core\Repository\VersionRepository;
use Metrics\Core\Repository\VersionRepositoryMock;

class ShowFileHierarchyMetricsInteractorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FileVersionRepository
     */
    private $fileVersionRepository;

    /**
     * @var MetricRepository
     */
    private $metricsRepository;

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @var VersionRepository
     */
    private $versionRepository;

    /**
     * @var Project
     */
    private $project;

    /**
     * @var Version
     */
    private $latestVersion;

    /**
     * @var ShowFileHierarchyMetricsInteractor
     */
    private $interactor;

    private $presenter;

    protected function setUp()
    {
        parent::setUp();

        $this->fileVersionRepository = new FileVersionRepositoryMock();
        $this->metricsRepository = new MetricRepositoryMock();
        $this->projectRepository = new ProjectRepositoryMock();
        $this->versionRepository = new VersionRepositoryMock();

        $this->project = $this->projectRepository->create('testproject');
        $this->latestVersion = $this->versionRepository->create($this->project, '1.0');
        $this->fileVersionRepository->createFile('/src/Entities/SomeEntity.php', $this->latestVersion);

        $this->presenter = new ArrayBasedShowFileHierarchyMetricsPresenter();

        $this->interactor = new ShowFileHierarchyMetricsInteractor(
            $this->projectRepository,
            $this->versionRepository,
            $this->fileVersionRepository,
            $this->metricsRepository,
            $this->presenter
        );
    }

    public function testReturnsFileHierarchy()
    {
        $result = $this->interactor->execute($this->project->getName());
        $expectedResult = [
            'label' => '1.0',
            'root' => [
                'isDir' => true,
                'name' => '',
                'path' => '',
                'files' => [
                    [
                        'isDir' => true,
                        'name' => 'src',
                        'path' => '/src',
                        'files' => [
                            [
                                'isDir' => true,
                                'name' => 'Entities',
                                'path' => '/src/Entities',
                                'files' => [
                                    [
                                        'isDir' => false,
                                        'name' => 'SomeEntity.php',
                                        'path' => '/src/Entities/SomeEntity.php'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $this->assertEquals($expectedResult, $result);
    }
}
