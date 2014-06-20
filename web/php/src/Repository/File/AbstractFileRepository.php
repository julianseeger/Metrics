<?php

namespace Metrics\Web\Repository\File;

class AbstractFileRepository
{
    private $directory;

    private $entityName;

    public function __construct($directory, $entityName)
    {
        $this->directory = $directory;
        $this->entityName = $entityName;
    }

    /**
     * @return array
     */
    public function load()
    {
        $filename = $this->getFilename();
        if (!file_exists($filename)) {
            return [];
        }
        return unserialize(file_get_contents($filename));
    }

    private function getFilename()
    {
        return rtrim($this->directory, '/') . '/' . $this->entityName . '.phpserialize';
    }

    public function save(array $data)
    {
        if (!is_dir($this->directory)) {
            mkdir($this->directory);
        }
        file_put_contents($this->getFilename(), serialize($data));
    }
}
