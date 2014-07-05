<?php

namespace Metrics\Core\Interactor\Sensor\Clover;

use Metrics\Core\Entity\DirectoryVersion;
use Metrics\Core\Entity\FileTreeHolder;
use Metrics\Core\Entity\FileVersion;
use Metrics\Core\Entity\MaterialType;
use Metrics\Core\Entity\Metric;
use Metrics\Core\Entity\Project;
use Metrics\Core\Entity\Version;
use Metrics\Core\Interactor\Sensor\AbstractSensor;
use Metrics\Core\Interactor\Sensor\Clover\Dto\Coverage;
use Metrics\Core\Interactor\Sensor\Clover\Dto\File;
use Metrics\Core\Interactor\Sensor\Clover\Dto\HasMetrics;
use Metrics\Core\Interactor\Sensor\Sensor;
use Metrics\Core\Repository\FileRepository;
use Metrics\Core\Repository\FileVersionRepository;
use Metrics\Core\Repository\MetricRepository;

class CloverSensor extends AbstractSensor implements Sensor
{
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

    public function execute($cloverXml, Project $project, Version $version)
    {
        $this->registerMetrics();
        $xml = simplexml_load_string($cloverXml);
        $coverage = Coverage::parse($xml);

        $commonPathPrefix = $this->detectCommonPathPrefix($coverage);

        foreach ($coverage->projects as $cloverProject) {
            foreach ($cloverProject->packages as $cloverPackage) {
                foreach ($cloverPackage->file as $cloverFile) {
                    $filename = str_replace($commonPathPrefix, '', $cloverFile->name);
                    $this->createFile($project, $cloverFile, $filename, $this->fileRepository);
                    $fileVersion = $this->createFile($version, $cloverFile, $filename, $this->fileVersionRepository);
                    $this->attachMetrics($fileVersion, $cloverFile);
                }
            }
            $this->attachMetrics($version->getRoot(), $cloverProject);
        }

        $this->attachDirectoryMetrics($version->getRoot());
    }

    private function detectCommonPathPrefix($coverage)
    {
        /** @var File $files */
        $files = [];
        foreach ($coverage->projects as $cloverProject) {
            foreach ($cloverProject->packages as $cloverPackage) {
                foreach ($cloverPackage->file as $cloverFile) {
                    $files[] = $cloverFile;
                }
            }
        }

        $paths = [];
        foreach ($files as $cloverFile) {
            $filepath = trim($cloverFile->name, '/');
            $paths[] = $filepath;
        }

        return $this->getPrefixByPathArray($paths);
    }

    /**
     * @param \Metrics\Core\Entity\FileTreeHolder $fileTreeHolder
     * @param \Metrics\Core\Interactor\Sensor\Clover\Dto\File $cloverFile
     * @param $filename
     * @param FileRepository|FileVersionRepository $repository
     * @return \Metrics\Core\Entity\File|\Metrics\Core\Entity\FileVersion
     */
    public function createFile(FileTreeHolder $fileTreeHolder, File $cloverFile, $filename, $repository)
    {
        $file = $repository->createFile($filename, $fileTreeHolder);
        if (isset($cloverFile->class)) {
            $file->setNamespace($cloverFile->class->namespace);
            $file->setClassname($cloverFile->class->name);
        }
        return $file;
    }

    /**
     * @param FileVersion|DirectoryVersion $fileVersion
     * @param HasMetrics $cloverFile
     */
    private function attachMetrics($fileVersion, $cloverFile)
    {
        $metrics = $cloverFile->metrics;
        $lineCoverageMetric = $this->metricRepository->getMetric(Metric::LINE_COVERAGE);
        $statementsMetric = $this->metricRepository->getMetric('statements');
        $coveredstatementsMetric = $this->metricRepository->getMetric('coveredstatements');

        if ($metrics->statements !== 0) {
            $lineCoverage = (float)$metrics->coveredstatements / (float)$metrics->statements;
            $fileVersion->addMetricValue($lineCoverageMetric, $lineCoverage);

            $fileVersion->addMetricValue($statementsMetric, $metrics->statements);
            $fileVersion->addMetricValue($coveredstatementsMetric, $metrics->coveredstatements);
        }
    }

    protected function calculateDirectoryMetrics(DirectoryVersion $dir)
    {
        $lineCoverageMetric = $this->metricRepository->getMetric(Metric::LINE_COVERAGE);
        $statementsMetric = $this->metricRepository->getMetric('statements');
        $coveredstatementsMetric = $this->metricRepository->getMetric('coveredstatements');

        if ($dir->getMetricValue($lineCoverageMetric) === null) {
            $statements = $dir->getMetricValue($statementsMetric, true);
            $coveredstatements = $dir->getMetricValue($coveredstatementsMetric, true);
            if ($statements != 0) {
                $coverage = (float)$coveredstatements / (float)$statements;

                $dir->addMetricValue($lineCoverageMetric, $coverage);
                $dir->addMetricValue($statementsMetric, $statements);
                $dir->addMetricValue($coveredstatementsMetric, $coveredstatements);
            }
        }
    }

    /**
     * @param MaterialType $materialType
     * @return bool
     */
    public function supportsMaterialType(MaterialType $materialType)
    {
        return $materialType->getName() === 'clover';
    }

    private function registerMetrics()
    {
        $coverage = $this->metricRepository->getMetric('coverage');
        $coverage->setInternal(false);
        $coverage->setPercentaged(true);
        $this->metricRepository->save($coverage);

        $statements = $this->metricRepository->getMetric('statements');
        $statements->setInternal(true);
        $statements->setPercentaged(false);
        $this->metricRepository->save($statements);

        $coveredstatements = $this->metricRepository->getMetric('coveredstatements');
        $coveredstatements->setInternal(true);
        $coveredstatements->setPercentaged(false);
        $this->metricRepository->save($coveredstatements);
    }
}
