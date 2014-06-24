<?php

namespace Metrics\Core\Presenter;

use Metrics\Core\Entity\Version;

interface ShowFileHierarchyMetricsPresenter
{
    /**
     * @param Version $version
     * @return mixed
     */
    public function present(Version $version);
}
