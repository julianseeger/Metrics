<?php

namespace Metrics\Web\Presenter;

use Metrics\Core\Entity\Metric;
use Metrics\Core\Entity\Version;
use Metrics\Core\Presenter\ArrayBased\ArrayBasedShowFileHierarchyPresenter;
use Metrics\Core\Presenter\ShowFileHierarchyPresenter;

class JsonShowFileHierarchyPresenter extends ArrayBasedShowFileHierarchyPresenter implements ShowFileHierarchyPresenter
{
    /**
     * @param Version $version
     * @param Metric[] $metrics
     * @return mixed
     */
    public function present(Version $version, array $metrics)
    {
        return json_encode(parent::present($version, $metrics));
    }
}
