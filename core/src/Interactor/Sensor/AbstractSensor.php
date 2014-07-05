<?php

namespace Metrics\Core\Interactor\Sensor;

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
}
