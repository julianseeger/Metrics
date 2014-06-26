<?php

namespace Metrics\Core\Repository;

use Metrics\Core\Entity\Metric;

interface MetricRepository
{
    /**
     * @param string $name
     * @return Metric
     */
    public function getMetric($name);

    /**
     * @param Metric $metric
     */
    public function save(Metric $metric);

    /**
     * @return Metric[]
     */
    public function getMetrics();
}
