<?php

namespace Metrics\Core\Presenter\ArrayBased;

use Metrics\Core\Entity\DirectoryVersion;
use Metrics\Core\Entity\FileVersion;
use Metrics\Core\Entity\Metric;
use Metrics\Core\Entity\Version;
use Metrics\Core\Presenter\ShowFileHierarchyPresenter;

class ArrayBasedShowFileHierarchyPresenter implements ShowFileHierarchyPresenter
{
    /**
     * @param Version $version
     * @param Metric[] $metrics
     * @return mixed
     */
    public function present(Version $version, array $metrics)
    {
        return [
            'label' => $version->getLabel(),
            'root' => $this->presentDirectory($version->getRoot()),
            'metrics' => $this->presentMetrics($metrics, $version->getRoot())
        ];
    }

    private function presentDirectory(DirectoryVersion $directory)
    {
        return [
            'isDir' => true,
            'name' => $directory->getName(),
            'path' => $directory->getPath(),
            'files' => $this->presentFiles($directory->getFiles())
        ];
    }

    private function presentFile(FileVersion $file)
    {
        return [
            'isDir' => false,
            'name' => $file->getName(),
            'path' => $file->getPath()
        ];
    }

    /**
     * @param FileVersion []|DirectoryVersion[]
     * @return array
     */
    private function presentFiles($files)
    {
        $presentation = [];
        foreach ($files as $file) {
            if ($file instanceof FileVersion) {
                $presentation[] = $this->presentFile($file);
            } else {
                $presentation[] = $this->presentDirectory($file);
            }
        }
        return $presentation;
    }

    /**
     * @param Metric[] $metrics
     * @param DirectoryVersion $dir
     * @return array
     */
    private function presentMetrics($metrics, DirectoryVersion $dir)
    {
        $pathes = [];
        $this->fillMetricsPerDirectory($pathes, $metrics, $dir);
        return $pathes;
    }

    /**
     * @param $pathes
     * @param Metric[] $metrics
     * @param DirectoryVersion $dir
     */
    private function fillMetricsPerDirectory(&$pathes, $metrics, DirectoryVersion $dir)
    {
        foreach ($dir->getFiles() as $file) {
            $this->fillMetricsPerPath($pathes, $metrics, $file);
        }
    }
    /**
     * @param $pathes
     * @param Metric[] $metrics
     * @param DirectoryVersion|FileVersion $dir
     */
    private function fillMetricsPerPath(&$pathes, $metrics, $dir)
    {
        $pathes[$dir->getPath()] = $this->getMetrics($metrics, $dir);
        if ($dir instanceof DirectoryVersion) {
            $this->fillMetricsPerDirectory($pathes, $metrics, $dir);
        }
    }

    /**
     * @param Metric[] $metrics
     * @param FileVersion|DirectoryVersion $file
     * @return array
     */
    private function getMetrics($metrics, $file)
    {
        $result = [];
        foreach ($metrics as $metric) {
            if ($metric->isInternal()) {
                continue;
            }
            $result[$metric->getName()] = $file->getMetricValue($metric, true);
        }
        return $result;
    }
}
