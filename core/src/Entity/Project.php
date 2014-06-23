<?php

namespace Metrics\Core\Entity;

class Project
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Directory
     */
    private $root = null;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

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
