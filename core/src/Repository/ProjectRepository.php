<?php

namespace Metrics\Core\Repository;

use Metrics\Core\Entity\Project;

interface ProjectRepository
{
    /**
     * @return Project[]
     */
    public function findAll();

    /**
     * @param \Metrics\Core\Entity\Project $project
     * @internal param $Project
     */
    public function save(Project $project);

    /**
     * @param $projectId
     * @return Project
     */
    public function findOne($projectId);

    /**
     * @param $name
     * @return Project
     */
    public function create($name);
}
