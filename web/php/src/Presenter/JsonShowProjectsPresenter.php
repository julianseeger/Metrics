<?php

namespace Metrics\Web\Presenter;

use Metrics\Core\Entity\Project;
use Metrics\Core\Presenter\ShowProjectsPresenter;

class JsonShowProjectsPresenter implements ShowProjectsPresenter
{
    /**
     * @param Project[] $projects
     * @return mixed
     */
    public function present(array $projects)
    {
        return json_encode(['projects' => $this->getProjectDtos($projects)], JSON_FORCE_OBJECT);
    }

    /**
     * @param Project[] $projects
     * @return array
     */
    private function getProjectDtos($projects)
    {
        $projectDtos = [];
        foreach ($projects as $project) {
            $projectDtos[] = $this->getProjectDto($project);
        }
        return $projectDtos;
    }

    private function getProjectDto(Project $project)
    {
        return [
            'name' => $project->getName()
        ];
    }
}
