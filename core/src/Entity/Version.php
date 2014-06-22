<?php

namespace Metrics\Core\Entity;

class Version
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
