<?php

namespace Metrics\Core\Entity;

class FileVersion extends File
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
     * @return int|float|null
     */
    public function getMetricValue(Metric $metric)
    {
        if (!isset($this->metricValues[$metric->getName()])) {
            return null;
        }

        return $this->metricValues[$metric->getName()];
    }
}
