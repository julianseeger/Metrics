<?php

namespace Metrics\Core\Presenter\ArrayBased;

use Metrics\Core\Entity\DirectoryVersion;
use Metrics\Core\Entity\FileVersion;
use Metrics\Core\Entity\Version;
use Metrics\Core\Presenter\ShowFileHierarchyMetricsPresenter;

class ArrayBasedShowFileHierarchyMetricsPresenter implements ShowFileHierarchyMetricsPresenter
{
    /**
     * @param Version $version
     * @return mixed
     */
    public function present(Version $version)
    {
        return [
            'label' => $version->getLabel(),
            'root' => $this->presentDirectory($version->getRoot())
        ];
    }

    private function presentDirectory(DirectoryVersion $directory)
    {
        return [
            'isDir' => true,
            'name' => $directory->getName(),
            'path' => $directory->getPath(),
            'files' => $this->presentFiles($directory->getFiles())
        ];
    }

    private function presentFile(FileVersion $file)
    {
        return [
            'isDir' => false,
            'name' => $file->getName(),
            'path' => $file->getPath()
        ];
    }

    /**
     * @param FileVersion []|DirectoryVersion[]
     * @return array
     */
    private function presentFiles($files)
    {
        $presentation = [];
        foreach ($files as $file) {
            if ($file instanceof FileVersion) {
                $presentation[] = $this->presentFile($file);
            } else {
                $presentation[] = $this->presentDirectory($file);
            }
        }
        return $presentation;
    }
}
