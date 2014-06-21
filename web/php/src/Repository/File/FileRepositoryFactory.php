<?php

namespace Metrics\Web\Repository\File;

use Metrics\Web\Repository\RepositoryFactory;

class FileRepositoryFactory implements RepositoryFactory
{
    private $directory;

    public function __construct($directory)
    {
        $this->directory = $directory;
    }

    /**
     * @return \Metrics\Core\Repository\ProjectRepository|FileProjectRepository
     */
    public function getProjectRepository()
    {
        return new FileProjectRepository($this->directory);
    }
}
