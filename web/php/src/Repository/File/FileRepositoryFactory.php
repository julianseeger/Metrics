<?php

namespace Metrics\Web\Repository\File;

use Metrics\Core\Entity\User;
use Metrics\Core\Repository\ProjectRepository;
use Metrics\Core\Repository\Simple\SimpleUserRepository;
use Metrics\Core\Repository\UserRepository;
use Metrics\Core\Repository\VersionRepository;
use Metrics\Web\Repository\AbstractRepositoryFactory;
use Metrics\Web\Repository\RepositoryFactory;

class FileRepositoryFactory extends AbstractRepositoryFactory implements RepositoryFactory
{
    private $directory;
    private $superadminUser;
    private $superadminPass;

    public function __construct($directory, $superadminUser, $superadminPass)
    {
        $this->directory = $directory;
        $this->superadminUser = $superadminUser;
        $this->superadminPass = $superadminPass;
    }

    /**
     * @return ProjectRepository
     */
    public function getProjectRepository()
    {
        return new FileProjectRepository($this->directory);
    }

    /**
     * @return VersionRepository
     */
    public function getVersionRepository()
    {
        return new FileVersionRepository($this->directory);
    }

    /**
     * @return FileRepositoryMock
     */
    public function getFileRepository()
    {
        return new FileRepositoryMock();
    }

    /**
     * @return FileVersionRepositoryMock
     */
    public function getFileVersionRepository()
    {
        return new FileVersionRepositoryMock();
    }

    /**
     * @return MetricRepositoryMock
     */
    public function getMetricsRepository()
    {
        return new FileMetricRepository($this->directory);
    }

    /**
     * @return UserRepository
     */
    public function getUserRepository()
    {
        $userRepository = new SimpleUserRepository();
        $userRepository->addUser(new User($this->superadminUser, $this->superadminPass));
        return $userRepository;
    }
}
