<?php

namespace Metrics\Web\Repository\File;

use Metrics\Core\Entity\Project;
use Metrics\Core\Repository\ProjectRepository;

class FileProjectRepository extends AbstractFileRepository implements ProjectRepository
{
    public function __construct($directory)
    {
        parent::__construct($directory, 'project');
    }

    /**
     * @return Project[]
     */
    public function findAll()
    {
        return $this->load();
    }

    /**
     * @param \Metrics\Core\Entity\Project $project
     * @internal param $Project
     */
    public function save(Project $project)
    {
        $projects = $this->load();
        $projects[] = $project;
        parent::save($projects);
    }

    /**
     * @param $projectId
     * @return Project
     */
    public function findOne($projectId)
    {
        // TODO: Implement findOne() method.
    }
}
