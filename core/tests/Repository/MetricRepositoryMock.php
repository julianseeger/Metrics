<?php

namespace Metrics\Core\Repository;

use Metrics\Core\Entity\Metric;

class MetricRepositoryMock implements MetricRepository
{
    /**
     * @param string $name
     * @return Metric
     */
    public function getMetric($name)
    {
        return new Metric($name);
    }
}
