<?php

namespace Metrics\Core\Repository;

use Metrics\Core\Entity\Project;
use Metrics\Core\Entity\Version;

interface VersionRepository
{
    /**
     * @param Project $project
     * @param string $label
     * @return Version $version
     */
    public function findOne(Project $project, $label);

    /**
     * @param Project $project
     * @return Version[]
     */
    public function findAll(Project $project);

    public function save(Version $version);
}
