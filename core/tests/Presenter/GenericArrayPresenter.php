<?php

namespace Metrics\Core\Presenter;

use Metrics\Core\Entity\Project;

class GenericArrayPresenter implements ShowProjectsPresenter
{
    /**
     * @param Project[] $projects
     * @return mixed
     */
    public function present(array $projects)
    {
        return $projects;
    }
}
