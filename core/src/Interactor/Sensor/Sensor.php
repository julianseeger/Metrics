<?php

namespace Metrics\Core\Interactor\Sensor;

use Metrics\Core\Entity\MaterialType;
use Metrics\Core\Entity\Project;
use Metrics\Core\Entity\Version;

interface Sensor
{
    /**
     * @param string $material
     * @param Project $project
     * @param Version $version
     * @return mixed
     */
    public function execute($material, Project $project, Version $version);

    /**
     * @param MaterialType $materialType
     * @return bool
     */
    public function supportsMaterialType(MaterialType $materialType);
}
