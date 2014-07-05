<?php

namespace Metrics\Core\Interactor\Sensor\Phpcs;

use Metrics\Core\Entity\DirectoryVersion;
use Metrics\Core\Entity\MaterialType;
use Metrics\Core\Entity\Project;
use Metrics\Core\Entity\Version;
use Metrics\Core\Interactor\Sensor\AbstractSensor;
use Metrics\Core\Interactor\Sensor\Phpcs\Dto\PhpcsReport;
use Metrics\Core\Interactor\Sensor\Sensor;
use Metrics\Core\Repository\FileRepository;
use Metrics\Core\Repository\FileVersionRepository;
use Metrics\Core\Repository\MetricRepository;

class PhpcsSensor extends AbstractSensor implements Sensor
{
    const VIOLATIONS_METRIC_NAME = 'PHPCS Violations';
    /**
     * @var FileRepository
     */
    private $fileRepository;

    /**
     * @var FileVersionRepository
     */
    private $fileVersionRepository;

    /**
     * @var MetricRepository
     */
    private $metricRepository;

    public function __construct(
        FileRepository $fileRepository,
        FileVersionRepository $fileVersionRepository,
        MetricRepository $metricRepository
    ) {
        $this->fileRepository = $fileRepository;
        $this->fileVersionRepository = $fileVersionRepository;
        $this->metricRepository = $metricRepository;
    }

    /**
     * @param string $material
     * @param Project $project
     * @param Version $version
     * @return mixed
     */
    public function execute($material, Project $project, Version $version)
    {
        $this->registerMetrics();

        $report = PhpcsReport::parse(simplexml_load_string($material));

        $prefix = $this->detectPrefix($report);
        $this->addFiles($report, $prefix, $version);

        $this->attachDirectoryMetrics($version->getRoot());
    }

    /**
     * @param MaterialType $materialType
     * @return bool
     */
    public function supportsMaterialType(MaterialType $materialType)
    {
        return $materialType->getName() === 'phpcs';
    }

    private function registerMetrics()
    {
        $metric = $this->metricRepository->getMetric(self::VIOLATIONS_METRIC_NAME);
        $metric->setInternal(false);
        $metric->setPercentaged(false);
        $this->metricRepository->save($metric);
    }

    private function detectPrefix(PhpcsReport $report)
    {
        $paths = [];
        foreach ($report->files as $file) {
            $paths[] = $file->name;
        }
        return $this->getPrefixByPathArray($paths);
    }

    protected function calculateDirectoryMetrics(DirectoryVersion $dir)
    {
        $violationsMetric = $this->metricRepository->getMetric(self::VIOLATIONS_METRIC_NAME);
        $value = $dir->getMetricValue($violationsMetric, true);
        $dir->addMetricValue($violationsMetric, $value);
    }

    private function addFiles(PhpcsReport $report, $prefix, Version $version)
    {
        $violationsMetric = $this->metricRepository->getMetric(self::VIOLATIONS_METRIC_NAME);
        foreach ($report->files as $file) {
            $relativePath = str_replace($prefix, '', $file->name);

            $fileVersion = $this->fileVersionRepository->createFile($relativePath, $version);
            $fileVersion->addMetricValue($violationsMetric, $file->warningCount + $file->errorCount);
        }
    }
}
