<?php

namespace Metrics\Core\Entity;

class File
{
    /**
     * @var File|null
     */
    private $parent = null;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $namespace = null;

    /**
     * @var string|null
     */
    private $classname = null;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param File|null $parent
     */
    public function setParent(File $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * @return File|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param null|string $classname
     */
    public function setClassname($classname)
    {
        $this->classname = $classname;
    }

    /**
     * @return null|string
     */
    public function getClassname()
    {
        return $this->classname;
    }

    /**
     * @param null|string $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @return null|string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }
}
