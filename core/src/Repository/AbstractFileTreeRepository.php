<?php

namespace Metrics\Core\Repository;

use Metrics\Core\Entity\Directory;
use Metrics\Core\Entity\File;
use Metrics\Core\Entity\FileTreeHolder;
use Metrics\Core\Entity\Project;

abstract class AbstractFileTreeRepository
{
    public function createFile($path, FileTreeHolder $project)
    {
        $this->ensureRoot($project);

        $parts = explode('/', trim($path, '/'));
        $filename = $parts[count($parts) - 1];
        $pathes = array_slice($parts, 0, count($parts) - 1);

        $dir = $project->getRoot();
        if (count($pathes) > 0) {
            $dir = $this->createDirectory(join('/', $pathes), $project);
        }

        $file = $this->createFileInstance($filename);
        $dir->addFile($file);
        return $file;
    }

    public function createDirectory($path, FileTreeHolder $project)
    {
        $path = trim($path, '/');
        $this->ensureRoot($project);

        $parent = $project->getRoot();
        $prefixPath = "";
        $pathes = explode('/', $path);
        for ($i = 0; $i < count($pathes) - 1; $i++) {
            if ($prefixPath !== "") {
                $prefixPath .= '/';
            }
            $prefixPath .= $pathes[$i];
            $parent = $this->createDirectory($prefixPath, $project);
        }

        $dirname = $pathes[count($pathes) - 1];
        if ($parent->hasFile($dirname)) {
            return $parent->getFile($dirname);
        }
        $dir = $this->createDirectoryInstance($dirname);
        $parent->addFile($dir);
        return $dir;
    }

    /**
     * @param $name
     * @return File
     */
    abstract protected function createFileInstance($name);

    /**
     * @param $name
     * @return Directory
     */
    abstract protected function createDirectoryInstance($name);

    /**
     * @param FileTreeHolder $project
     */
    public function ensureRoot(FileTreeHolder $project)
    {
        if ($project->getRoot() === null) {
            $project->setRoot($this->createDirectoryInstance(""));
        }
    }
}
