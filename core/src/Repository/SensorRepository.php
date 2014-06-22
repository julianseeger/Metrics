<?php

namespace Metrics\Core\Repository;

use Metrics\Core\Entity\MaterialType;
use Metrics\Core\Interactor\Sensor\Sensor;

interface SensorRepository
{
    /**
     * @param MaterialType $type
     * @return Sensor[]
     */
    public function findByType(MaterialType $type);
}
