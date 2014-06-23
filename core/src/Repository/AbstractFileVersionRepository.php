<?php

namespace Metrics\Core\Repository;

use Metrics\Core\Entity\FileTreeHolder;
use Metrics\Core\Entity\Version;

abstract class AbstractFileVersionRepository extends AbstractFileTreeRepository implements FileVersionRepository
{
    public function createFile($path, Version $project)
    {
        return parent::createFile($path, $project);
    }

    public function createDirectory($path, Version $project)
    {
        return parent::createDirectory($path, $project);
    }
}
