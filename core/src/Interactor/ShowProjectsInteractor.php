<?php

namespace Metrics\Core\Interactor;

use Metrics\Core\Presenter\ShowProjectsPresenter;
use Metrics\Core\Repository\ProjectRepository;

class ShowProjectsInteractor
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @var ShowProjectsPresenter
     */
    private $presenter;

    public function __construct(ProjectRepository $projectRepository, ShowProjectsPresenter $presenter)
    {
        $this->projectRepository = $projectRepository;
        $this->presenter = $presenter;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        return $this->presenter->present($this->projectRepository->findAll());
    }
}
