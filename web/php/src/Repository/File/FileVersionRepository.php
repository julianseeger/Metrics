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
            if ($version->getProject() == $project && $version->getLabel() == $label) {
                return $version;
            }
        }
        throw new \Exception("version not found");
    }

    /**
     * @param \Metrics\Core\Entity\Version $version
     */
    public function save(Version $version)
    {
        $versions = $this->load();
        $versions[] = $version;
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
            if ($version->getProject() == $project) {
                $result[] = $version;
            }
        }
        return $result;
    }
}
 