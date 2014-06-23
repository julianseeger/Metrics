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
        $this->files[$file->getName()] = $file;
    }

    /**
     * @return File[]
     */
    public function getFiles()
    {
        return $this->files;
    }

    public function hasFile($name)
    {
        return isset($this->files[$name]);
    }

    public function getFile($name)
    {
        return $this->files[$name];
    }
}
