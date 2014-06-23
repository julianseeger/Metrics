<?php

namespace Metrics\Core\Entity;

/**
 * Class Version
 * @package Metrics\Core\Entity
 * @method DirectoryVersion getRoot()
 */
class Version extends FileTreeHolder
{
    /**
     * @var Project
     */
    private $project;

    private $label;

    public function __construct($label, Project $project)
    {
        $this->label = $label;
        $this->project = $project;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return \Metrics\Core\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }
}
