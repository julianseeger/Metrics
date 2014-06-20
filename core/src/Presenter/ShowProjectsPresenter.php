<?php

namespace Metrics\Core\Presenter;

use Metrics\Core\Entity\Project;

interface ShowProjectsPresenter
{
    /**
     * @param Project[] $projects
     * @return mixed
     */
    public function present(array $projects);
}
