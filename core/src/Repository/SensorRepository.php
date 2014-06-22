<?php

namespace Metrics\Core\Repository;

use Metrics\Core\Entity\MetricType;
use Metrics\Core\Interactor\Sensor\Sensor;

interface SensorRepository
{
    /**
     * @param MetricType $type
     * @return Sensor[]
     */
    public function findByType(MetricType $type);
}
