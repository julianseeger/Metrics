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
        $this->projects[] = $project;
    }

    /**
     * @param $projectId
     * @return Project
     */
    public function findOne($projectId)
    {

    }
}
