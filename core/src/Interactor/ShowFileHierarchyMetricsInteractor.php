<?php

namespace Metrics\Core\Interactor;

use Metrics\Core\Entity\Project;
use Metrics\Core\Presenter\ShowFileHierarchyMetricsPresenter;
use Metrics\Core\Repository\FileVersionRepository;
use Metrics\Core\Repository\MetricRepository;
use Metrics\Core\Repository\ProjectRepository;
use Metrics\Core\Repository\VersionRepository;

class ShowFileHierarchyMetricsInteractor
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
     * @var VersionRepository
     */
    private $versionRepository;

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @var ShowFileHierarchyMetricsPresenter
     */
    private $presenter;

    /**
     * @param ProjectRepository $projectRepository
     * @param VersionRepository $versionRepository
     * @param FileVersionRepository $fileVersionRepository
     * @param MetricRepository $metricsRepository
     * @param ShowFileHierarchyMetricsPresenter $presenter
     */
    public function __construct(
        ProjectRepository $projectRepository,
        VersionRepository $versionRepository,
        FileVersionRepository $fileVersionRepository,
        MetricRepository $metricsRepository,
        ShowFileHierarchyMetricsPresenter $presenter
    ) {
        $this->projectRepository = $projectRepository;
        $this->versionRepository = $versionRepository;
        $this->fileVersionRepository = $fileVersionRepository;
        $this->metricsRepository = $metricsRepository;
        $this->presenter = $presenter;
    }

    /**
     * @param string $project
     * @return mixed
     */
    public function execute($project)
    {
        $project = $this->projectRepository->findOne($project);
        $version = $this->versionRepository->findLatest($project);
        return $this->presenter->present($version);
    }
}
