<?php

namespace Metrics\Core\Entity;

abstract class FileTreeHolder
{
    /**
     * @var File
     */
    private $root = null;

    /**
     * @param Directory $root
     */
    public function setRoot(Directory $root)
    {
        $this->root = $root;
        $root->setParent();
    }

    /**
     * @return Directory
     */
    public function getRoot()
    {
        return $this->root;
    }
}
