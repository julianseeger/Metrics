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
     * @param \Metrics\Core\Entity\Project $modifiedProject
     */
    public function save(Project $modifiedProject)
    {
        /** @var Project[] $projects */
        $projects = $this->load();
        foreach ($projects as $key => $project) {
            if ($modifiedProject->getName() == $project->getName()) {
                $projects[$key] = $modifiedProject;
            }
        }
        parent::save($projects);
    }

    /**
     * @param $projectName
     * @return Project
     */
    public function findOne($projectName)
    {
        /** @var Project[] $projects */
        $projects = $this->load();
        foreach ($projects as $project) {
            if ($project->getName() == $projectName) {
                return $project;
            }
        }
    }

    /**
     * @param $name
     * @return Project
     */
    public function create($name)
    {
        $project = new Project($name);
        $projects = $this->load();
        $projects[] = $project;
        parent::save($projects);
        return $project;
    }
}
