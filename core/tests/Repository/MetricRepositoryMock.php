<?php

namespace Metrics\Core\Repository;

use Metrics\Core\Entity\Metric;

class MetricRepositoryMock implements MetricRepository
{
    private $metrics = [];

    /**
     * @param string $name
     * @return Metric
     */
    public function getMetric($name)
    {
        if (!isset($this->metrics[$name])) {
            $this->metrics[$name] = new Metric($name);
        }
        return $this->metrics[$name];
    }

    /**
     * @param Metric $metric
     */
    public function save(Metric $metric)
    {
        $this->metrics[$metric->getName()] = $metric;
    }

    /**
     * @return Metric[]
     */
    public function getMetrics()
    {
        return $this->metrics;
    }
}
