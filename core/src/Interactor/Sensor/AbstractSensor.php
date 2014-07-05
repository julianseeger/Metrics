<?php

namespace Metrics\Core\Interactor\Sensor;

use Metrics\Core\Entity\DirectoryVersion;

abstract class AbstractSensor implements Sensor
{
    /**
     * @param array $paths
     * @return string $prefix
     */
    public function getPrefixByPathArray(array $paths)
    {
        $prefix = null;

        foreach ($paths as $path) {
            $pathArray = explode('/', rtrim($path, '/'));
            if ($prefix === null) {
                $prefix = $pathArray;
            } else {
                for ($i = 0; $i < count($prefix); $i++) {
                    if (!isset($pathArray[$i]) || $pathArray[$i] != $prefix[$i]) {
                        $prefix = array_slice($prefix, 0, $i);
                        break;
                    }
                }
            }
        }

        return join('/', $prefix);
    }

    /**
     * @param DirectoryVersion $dir
     */
    protected function attachDirectoryMetrics(DirectoryVersion $dir)
    {
        foreach ($dir->getFiles() as $file) {
            if ($file instanceof DirectoryVersion) {
                $this->attachDirectoryMetrics($file);
            }
        }

        $this->calculateDirectoryMetrics($dir);
    }

    abstract protected function calculateDirectoryMetrics(DirectoryVersion $dir);
}
