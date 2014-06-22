<?php

namespace Metrics\Web\Repository\File;

use Metrics\Core\Repository\ProjectRepository;
use Metrics\Core\Repository\VersionRepository;
use Metrics\Web\Repository\AbstractRepositoryFactory;
use Metrics\Web\Repository\RepositoryFactory;

class FileRepositoryFactory extends AbstractRepositoryFactory implements RepositoryFactory
{
    private $directory;

    public function __construct($directory)
    {
        $this->directory = $directory;
    }

    /**
     * @return ProjectRepository
     */
    public function getProjectRepository()
    {
        return new FileProjectRepository($this->directory);
    }

    /**
     * @return VersionRepository
     */
    public function getVersionRepository()
    {
        return new FileVersionRepository($this->directory);
    }
}
