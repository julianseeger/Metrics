<?php

namespace Metrics\Web\Repository;

use Metrics\Core\Repository\ProjectRepository;
use Metrics\Core\Repository\VersionRepository;

interface RepositoryFactory
{
    /**
     * @return ProjectRepository
     */
    public function getProjectRepository();

    /**
     * @return VersionRepository
     */
    public function getVersionRepository();
}
