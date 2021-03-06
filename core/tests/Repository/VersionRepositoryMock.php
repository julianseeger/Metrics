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
        $this->versions[$version->getProject()->getName() . '-' . $version->getLabel()];
    }

    public function findAll(Project $project, $limit = null)
    {
        $results = [];
        foreach ($this->versions as $version) {
            if ($version->getProject() === $project) {
                $results[] = $version;
            }
        }

        if ($limit !== null && count($results) > $limit) {
            $results = array_slice($results, count($results) - $limit);
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
        $this->versions[$project->getName() . "-" . $label] = $version;
        return $version;
    }

    /**
     * @param Project $project
     * @return Version
     */
    public function findLatest(Project $project)
    {
        $versions = $this->findAll($project);
        $version = null;
        foreach ($versions as $v) {
            $version = $v;
        }
        return $version;
    }
}
