<?php

namespace Metrics\Web\Repository;

use Metrics\Core\Repository\SensorRepository;
use Metrics\Core\Repository\Simple\SimpleSensorRepository;

abstract class AbstractRepositoryFactory implements RepositoryFactory
{
    /**
     * @return SensorRepository
     */
    public function getSensorRepository()
    {
        return new SimpleSensorRepository();
    }
}
