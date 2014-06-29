<?php

namespace Metrics\Core\ViewDto;

use Metrics\Core\Entity\Metric;
use Metrics\Core\Entity\Version;

class ShowTimeSeriesResult
{
    /**
     * @var Metric
     */
    private $metric;

    /**
     * @var Version[]
     */
    private $versions = [];

    /**
     * @var array
     */
    private $metricValues = [];

    public function __construct(Metric $metric)
    {
        $this->metric = $metric;
    }

    /**
     * @return Metric
     */
    public function getMetric()
    {
        return $this->metric;
    }

    /**
     * @return Version[]
     */
    public function getVersions()
    {
        return $this->versions;
    }

    /**
     * @param Version $version
     * @param $value
     */
    public function addValue(Version $version, $value)
    {
        $this->versions[] = $version;
        $this->metricValues[$version->getLabel()] = $value;
    }

    /**
     * @param Version $version
     * @return mixed
     */
    public function getValue(Version $version)
    {
        return $this->metricValues[$version->getLabel()];
    }
}
