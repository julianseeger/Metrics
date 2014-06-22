<?php

namespace Metrics\Core\Repository;

use Metrics\Core\Entity\Project;
use Metrics\Core\Entity\Version;

class VersionRepositoryMock implements VersionRepository
{
    /**
     * @var Version[]
     */
    private $versions = [];

    /**
     * @param Project $project
     * @param string $label
     * @throws \Exception
     * @return Version $version
     */
    public function findOne(Project $project, $label)
    {
        foreach ($this->versions as $version) {
            if ($version->getProject() === $project && $version->getLabel() === $label) {
                return $version;
            }
        }

        throw new \Exception("Version not found");
    }

    public function save(Version $version)
    {
    }

    public function findAll(Project $project)
    {
        $results = [];
        foreach ($this->versions as $version) {
            if ($version->getProject() === $project) {
                $results[] = $version;
            }
        }
        return $results;
    }

    /**
     * @param Project $project
     * @param $label
     * @return Version
     */
    public function create(Project $project, $label)
    {
        $version = new Version($label, $project);
        $this->versions[] = $version;
        return $version;
    }
}
