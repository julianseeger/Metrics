<?php

namespace Metrics\Core\Repository;

use Metrics\Core\Entity\File;
use Metrics\Core\Entity\Project;

interface FileRepository
{
    /**
     * @param $path
     * @param Project $project
     * @return File
     */
    public function createFile($path, Project $project);

    /**
     * @param $path
     * @param Project $project
     * @return File
     */
    public function createDirectory($path, Project $project);
}
