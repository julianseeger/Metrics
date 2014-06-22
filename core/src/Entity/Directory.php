<?php

namespace Metrics\Core\Entity;

class Directory extends File
{
    /**
     * @var File[]
     */
    private $files = [];

    /**
     * @param File $file
     */
    public function addFile(File $file)
    {
        $file->setParent($this);
        if (!in_array($file, $this->files)) {
            $this->files[] = $file;
        }
    }

    /**
     * @return File[]
     */
    public function getFiles()
    {
        return $this->files;
    }
}
