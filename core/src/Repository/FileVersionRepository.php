<?php

namespace Metrics\Core\Repository;

use Metrics\Core\Entity\DirectoryVersion;
use Metrics\Core\Entity\FileVersion;
use Metrics\Core\Entity\Version;

interface FileVersionRepository
{
    /**
     * @param $path
     * @param \Metrics\Core\Entity\Version $version
     * @return FileVersion
     */
    public function createFile($path, Version $version);

    /**
     * @param $path
     * @param Version $version
     * @return DirectoryVersion
     */
    public function createDirectory($path, Version $version);
}
