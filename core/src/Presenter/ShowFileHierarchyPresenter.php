<?php

namespace Metrics\Core\Presenter;

use Metrics\Core\Entity\Metric;
use Metrics\Core\Entity\Version;

interface ShowFileHierarchyPresenter
{
    /**
     * @param Version $version
     * @param Metric[] $metrics
     * @return mixed
     */
    public function present(Version $version, array $metrics);
}
