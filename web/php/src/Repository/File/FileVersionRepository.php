<?php

namespace Metrics\Web\Repository\File;

use Metrics\Core\Entity\Project;
use Metrics\Core\Entity\Version;
use Metrics\Core\Repository\VersionRepository;

class FileVersionRepository extends AbstractFileRepository implements VersionRepository
{
    public function __construct($directory)
    {
        parent::__construct($directory, 'version');
    }

    /**
     * @param Project $project
     * @param string $label
     * @throws \Exception
     * @return Version $version
     */
    public function findOne(Project $project, $label)
    {
        /** @var Version[] $versions */
        $versions = $this->load();
        foreach ($versions as $version) {
            if ($version->getProject()->getName() == $project->getName() && $version->getLabel() == $label) {
                return $version;
            }
        }
        throw new \Exception("version not found");
    }

    /**
     * @param \Metrics\Core\Entity\Version $modifiedVersion
     */
    public function save(Version $modifiedVersion)
    {
        /** @var Version[] $versions */
        $versions = $this->load();
        foreach ($versions as $key => $version) {
            if ($version->getProject()->getName() == $modifiedVersion->getProject()->getName()
                && $version->getLabel() == $modifiedVersion->getLabel()
            ) {
                $versions[$key] = $modifiedVersion;
            }
        }
        parent::save($versions);
    }

    /**
     * @param Project $project
     * @return Version[]
     */
    public function findAll(Project $project)
    {
        $result = [];
        /** @var Version[] $versions */
        $versions = $this->load();
        foreach ($versions as $version) {
            if ($version->getProject()->getName() == $project->getName()) {
                $result[] = $version;
            }
        }
        return $result;
    }

    /**
     * @param Project $project
     * @param $label
     * @return Version
     */
    public function create(Project $project, $label)
    {
        $versions = $this->load();
        $version = new Version($label, $project);
        $versions[] = $version;
        parent::save($versions);
        return $version;
    }
}
