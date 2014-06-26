<?php

namespace Metrics\Web\Repository\File;

use Metrics\Core\Entity\Metric;
use Metrics\Core\Repository\MetricRepository;

class FileMetricRepository extends AbstractFileRepository implements MetricRepository
{
    public function __construct($directory)
    {
        parent::__construct($directory, 'metric');
    }

    /**
     * @param string $name
     * @return Metric
     */
    public function getMetric($name)
    {
        /** @var Metric[] $metrics */
        $metrics = $this->load();
        if (!isset($metrics[$name])) {
            $metrics[$name] = new Metric($name);
            parent::save($metrics);
        }
        return $metrics[$name];
    }

    /**
     * @param Metric $metric
     */
    public function save(Metric $metric)
    {
        $metrics = $this->load();
        $metrics[$metric->getName()] = $metric;
        parent::save($metrics);
    }

    /**
     * @return Metric[]
     */
    public function getMetrics()
    {
        return $this->load();
    }
}
