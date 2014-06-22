<?php

namespace Metrics\Core\Repository\Simple;

use Metrics\Core\Entity\MaterialType;
use Metrics\Core\Interactor\Sensor\Sensor;
use Metrics\Core\Repository\SensorRepository;

class SimpleSensorRepository implements SensorRepository
{
    private $sensors = [

    ];

    /**
     * @param MaterialType $type
     * @return Sensor[]
     */
    public function findByType(MaterialType $type)
    {
        $name = $type->getName();
        if (isset($this->sensors[$name])) {
            return $this->sensors[$name];
        }
        return [];
    }
}
