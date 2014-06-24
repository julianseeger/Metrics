<?php

namespace Metrics\Core\Interactor;

use Metrics\Core\Entity\Project;
use Metrics\Core\Presenter\ShowFileHierarchyMetricsPresenter;
use Metrics\Core\Repository\FileVersionRepository;
use Metrics\Core\Repository\MetricRepository;
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
     * @var ShowFileHierarchyMetricsPresenter
     */
    private $presenter;

    /**
     * @param VersionRepository $versionRepository
     * @param FileVersionRepository $fileVersionRepository
     * @param MetricRepository $metricsRepository
     * @param ShowFileHierarchyMetricsPresenter $presenter
     */
    public function __construct(
        VersionRepository $versionRepository,
        FileVersionRepository $fileVersionRepository,
        MetricRepository $metricsRepository,
        ShowFileHierarchyMetricsPresenter $presenter
    ) {
        $this->versionRepository = $versionRepository;
        $this->fileVersionRepository = $fileVersionRepository;
        $this->metricsRepository = $metricsRepository;
        $this->presenter = $presenter;
    }

    /**
     * @param Project $project
     * @return mixed
     */
    public function execute(Project $project)
    {
        $version = $this->versionRepository->findLatest($project);
        return $this->presenter->present($version);
    }
}
