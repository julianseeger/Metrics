<?php

namespace Metrics\Core\Entity;

/**
 * Class DirectoryVersion
 * @package Metrics\Core\Entity
 * @method FileVersion[]|DirectoryVersion[] getFiles()
 */
class DirectoryVersion extends Directory
{
    /**
     * @var int[]|float[]
     */
    private $metricValues = [];

    /**
     * @param Metric $metric
     * @param int|float $value
     */
    public function addMetricValue(Metric $metric, $value)
    {
        $this->metricValues[$metric->getName()] = $value;
    }

    /**
     * @param Metric $metric
     * @param bool $allowComposite
     * @return int|float|null
     */
    public function getMetricValue(Metric $metric, $allowComposite = false)
    {
        if (!isset($this->metricValues[$metric->getName()])) {
            if ($allowComposite) {
                $value = 0.0;
                foreach ($this->getFiles() as $file) {
                    $childValue = $file->getMetricValue($metric, true);
                    if ($childValue === null) {
                        continue;
                    }
                    $value += $childValue;
                }
                return $value;
            }
            return null;
        }

        return $this->metricValues[$metric->getName()];
    }

    public function getMetricValues()
    {
        return $this->metricValues;
    }
}
