<?php

namespace Metrics\Web\Repository;

use Metrics\Core\Repository\ProjectRepository;

interface RepositoryFactory
{
    /**
     * @return ProjectRepository
     */
    public function getProjectRepository();
}
