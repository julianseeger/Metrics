<?php

namespace Metrics\Core\Repository;

use Metrics\Core\Entity\Project;

class ProjectRepositoryMock implements ProjectRepository
{
    /**
     * @var Project[]
     */
    public $projects = [];

    /**
     * @return Project
     */
    public function findAll()
    {
        return $this->projects;
    }

    /**
     * @param \Metrics\Core\Entity\Project $project
     * @internal param $Project
     */
    public function save(Project $project)
    {
        $this->projects[$project->getName()] = $project;
    }

    /**
     * @param $name
     * @return Project
     */
    public function findOne($name)
    {
        return $this->projects[$name];
    }

    /**
     * @param $name
     * @return Project
     */
    public function create($name)
    {
        $project = new Project($name);
        $this->projects[$name] = $project;
        return $project;
    }
}
