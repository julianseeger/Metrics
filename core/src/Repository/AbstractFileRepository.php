<?php

namespace Metrics\Core\Repository;

use Metrics\Core\Entity\Directory;
use Metrics\Core\Entity\File;
use Metrics\Core\Entity\Project;

abstract class AbstractFileRepository implements FileRepository
{
    public function createFile($path, Project $project)
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

    public function createDirectory($path, Project $project)
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

        $dir = $this->createDirectoryInstance($pathes[count($pathes) - 1]);
        $parent->addFile($dir);
        return $dir;
    }

    /**
     * @param $name
     * @return File
     */
    protected abstract function createFileInstance($name);

    /**
     * @param $name
     * @return Directory
     */
    protected abstract function createDirectoryInstance($name);

    /**
     * @param Project $project
     */
    public function ensureRoot(Project $project)
    {
        if ($project->getRoot() === null) {
            $project->setRoot($this->createDirectoryInstance(""));
        }
    }
}
