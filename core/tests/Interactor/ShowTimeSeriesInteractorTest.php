<?php

namespace Interactor;

use Metrics\Core\Entity\Project;
use Metrics\Core\Entity\Version;
use Metrics\Core\Interactor\ShowFileHierarchyInteractor;
use Metrics\Core\Interactor\ShowTimeSeriesInteractor;
use Metrics\Core\Presenter\GenericShowTimeSeriesPresenter;
use Metrics\Core\Repository\FileRepositoryMock;
use Metrics\Core\Repository\FileVersionRepositoryMock;
use Metrics\Core\Repository\MetricRepository;
use Metrics\Core\Repository\MetricRepositoryMock;
use Metrics\Core\Repository\ProjectRepository;
use Metrics\Core\Repository\ProjectRepositoryMock;
use Metrics\Core\Repository\VersionRepository;
use Metrics\Core\Repository\VersionRepositoryMock;
use Metrics\Core\ViewDto\ShowTimeSeriesResult;

class ShowTimeSeriesInteractorTest extends \PHPUnit_Framework_TestCase
{
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
     * @var ShowTimeSeriesInteractor
     */
    private $interactor;

    private $presenter;

    protected function setUp()
    {
        parent::setUp();

        $this->metricsRepository = new MetricRepositoryMock();
        $this->projectRepository = new ProjectRepositoryMock();
        $this->versionRepository = new VersionRepositoryMock();

        $this->project = $this->projectRepository->create('testproject');

        $this->presenter = new GenericShowTimeSeriesPresenter();

        $this->interactor = new ShowTimeSeriesInteractor(
            $this->projectRepository,
            $this->versionRepository,
            $this->metricsRepository,
            $this->presenter
        );
    }

    public function testReturnsVersions()
    {
        $fileVersionRepository = new FileVersionRepositoryMock();
        $this->projectRepository->save($this->project);

        $coverage = $this->metricsRepository->getMetric('coverage');

        //add not contained versions
        for ($i = 0; $i < 10; $i++) {
            $version = $this->versionRepository->create($this->project, 'v' . $i);
            $fileVersionRepository->ensureRoot($version);
            $this->versionRepository->save($version);
        }

        //add contained versions
        $versions = [];
        for ($i = 10; $i < 40; $i++) {
            $version = $this->versionRepository->create($this->project, 'v' . $i);
            $fileVersionRepository->ensureRoot($version);
            $version->getRoot()->addMetricValue($coverage, $i);
            $this->versionRepository->save($version);
            $versions[] = $version;
        }

        /** @var ShowTimeSeriesResult $result */
        $result = $this->interactor->execute($this->project->getName(), $coverage->getName());

        $this->assertEquals($versions, $result->getVersions());
        /** @var Version $version */
        foreach ($versions as $version) {
            $this->assertEquals($version->getRoot()->getMetricValue($coverage), $result->getValue($version));
        }
    }

    public function testHoldsNullForMissingVersions()
    {
        $fileVersionRepository = new FileVersionRepositoryMock();
        $this->projectRepository->save($this->project);

        $coverage = $this->metricsRepository->getMetric('coverage');

        $version = $this->versionRepository->create($this->project, 'v1');
        $fileVersionRepository->ensureRoot($version);
        $this->versionRepository->save($version);

        /** @var ShowTimeSeriesResult $result */
        $result = $this->interactor->execute($this->project->getName(), $coverage->getName());

        $this->assertEquals(1, count($result->getVersions()));
        $this->assertEquals(null, $result->getValue($version));
    }

    public function testHoldsNullForMissingRoots()
    {
        $this->projectRepository->save($this->project);

        $coverage = $this->metricsRepository->getMetric('coverage');

        $version = $this->versionRepository->create($this->project, 'v1');

        /** @var ShowTimeSeriesResult $result */
        $result = $this->interactor->execute($this->project->getName(), $coverage->getName());

        $this->assertEquals(1, count($result->getVersions()));
        $this->assertEquals(null, $result->getValue($version));
    }
}
