<?php

namespace Metrics\Core\Interactor;

use Metrics\Core\Presenter\ShowTimeSeriesPresenter;
use Metrics\Core\Repository\MetricRepository;
use Metrics\Core\Repository\ProjectRepository;
use Metrics\Core\Repository\VersionRepository;
use Metrics\Core\ViewDto\ShowTimeSeriesResult;

class ShowTimeSeriesInteractor
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @var VersionRepository
     */
    private $versionRepository;

    /**
     * @var MetricRepository
     */
    private $metricRepository;

    /**
     * @var ShowTimeSeriesPresenter
     */
    private $presenter;

    public function __construct(
        ProjectRepository $projectRepository,
        VersionRepository $versionRepository,
        MetricRepository $metricRepository,
        ShowTimeSeriesPresenter $presenter
    ) {
        $this->projectRepository = $projectRepository;
        $this->versionRepository = $versionRepository;
        $this->metricRepository = $metricRepository;
        $this->presenter = $presenter;
    }

    /**
     * @param string $projectName
     * @param string $metricName
     * @param int $seriesLength
     * @return \Metrics\Core\ViewDto\ShowTimeSeriesResult
     */
    public function execute($projectName, $metricName, $seriesLength = 30)
    {
        $metric = $this->metricRepository->getMetric($metricName);
        $result = new ShowTimeSeriesResult($metric);

        $project = $this->projectRepository->findOne($projectName);

        $versions = $this->versionRepository->findAll($project, $seriesLength);

        foreach ($versions as $version) {
            $value = null;
            if ($version->getRoot() !== null) {
                $value = $version->getRoot()->getMetricValue($metric);
            }
            $result->addValue($version, $value);
        }

        return $result;
    }
}
