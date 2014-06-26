<?php

namespace Metrics\Core\Interactor;

use Metrics\Core\Entity\Project;
use Metrics\Core\Entity\Version;
use Metrics\Core\Presenter\ArrayBased\ArrayBasedShowFileHierarchyPresenter;
use Metrics\Core\Repository\FileVersionRepository;
use Metrics\Core\Repository\FileVersionRepositoryMock;
use Metrics\Core\Repository\MetricRepository;
use Metrics\Core\Repository\MetricRepositoryMock;
use Metrics\Core\Repository\ProjectRepository;
use Metrics\Core\Repository\ProjectRepositoryMock;
use Metrics\Core\Repository\VersionRepository;
use Metrics\Core\Repository\VersionRepositoryMock;

class ShowFileHierarchyInteractorTest extends \PHPUnit_Framework_TestCase
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
     * @var ShowFileHierarchyInteractor
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
        $file = $this->fileVersionRepository->createFile('/src/Entities/SomeEntity.php', $this->latestVersion);
        $file->addMetricValue($this->metricsRepository->getMetric('coverage'), '0.9');
        $statements = $this->metricsRepository->getMetric('statements');
        $statements->setInternal(true);
        $this->metricsRepository->save($statements);
        $file->addMetricValue($statements, '10');

        $this->presenter = new ArrayBasedShowFileHierarchyPresenter();

        $this->interactor = new ShowFileHierarchyInteractor(
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
            ],
            'metrics' => [
                '/src' => ['coverage' => '0.9'],
                '/src/Entities' => ['coverage' => '0.9'],
                '/src/Entities/SomeEntity.php' => ['coverage' => '0.9'],
            ]
        ];

        $this->assertEquals($expectedResult, $result);
    }
}
