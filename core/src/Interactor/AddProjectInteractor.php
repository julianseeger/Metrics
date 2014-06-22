<?php

namespace Metrics\Core\Interactor;

use Metrics\Core\Entity\Project;
use Metrics\Core\Repository\ProjectRepository;

class AddProjectInteractor
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function execute($name)
    {
        $project = new Project('a');
        $project->setName($name);
        $this->projectRepository->save($project);
    }
}
