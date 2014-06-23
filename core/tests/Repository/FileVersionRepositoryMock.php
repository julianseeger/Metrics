<?php

namespace Metrics\Core\Repository;

use Metrics\Core\Entity\Directory;
use Metrics\Core\Entity\DirectoryVersion;
use Metrics\Core\Entity\File;
use Metrics\Core\Entity\FileVersion;

class FileVersionRepositoryMock extends AbstractFileVersionRepository
{
    /**
     * @param $name
     * @return File
     */
    protected function createFileInstance($name)
    {
        return new FileVersion($name);
    }

    /**
     * @param $name
     * @return Directory
     */
    protected function createDirectoryInstance($name)
    {
        return new DirectoryVersion($name);
    }
}
