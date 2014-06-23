<?php

namespace Metrics\Core\Entity;

class Directory extends File
{
    /**
     * @var File[]
     */
    private $files = [];

    /**
     * @var string
     */
    private $package = null;

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

    /**
     * @param string $package
     */
    public function setPackage($package)
    {
        $this->package = $package;
    }

    /**
     * @return string
     */
    public function getPackage()
    {
        return $this->package;
    }
}
