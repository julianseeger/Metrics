<?php

namespace Metrics\Core\Repository;

use Metrics\Core\Entity\FileTreeHolder;
use Metrics\Core\Entity\Project;

abstract class AbstractFileRepository extends AbstractFileTreeRepository implements FileRepository
{
    public function createFile($path, Project $project)
    {
        return parent::createFile($path, $project);
    }

    public function createDirectory($path, Project $project)
    {
        return parent::createDirectory($path, $project);
    }
}
