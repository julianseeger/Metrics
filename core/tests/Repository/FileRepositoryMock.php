<?php

namespace Metrics\Core\Repository;

use Metrics\Core\Entity\Directory;
use Metrics\Core\Entity\File;

class FileRepositoryMock extends AbstractFileRepository
{
    /**
     * @param $name
     * @return File
     */
    protected function createFileInstance($name)
    {
        return new File($name);
    }

    /**
     * @param $name
     * @return Directory
     */
    protected function createDirectoryInstance($name)
    {
        return new Directory($name);
    }
}
