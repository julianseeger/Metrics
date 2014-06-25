<?php

namespace Metrics\Web\Presenter;

use Metrics\Core\Entity\Version;
use Metrics\Core\Presenter\ArrayBased\ArrayBasedShowFileHierarchyMetricsPresenter;
use Metrics\Core\Presenter\ShowFileHierarchyMetricsPresenter;

class JsonShowFileHierarchyMetricsPresenter extends ArrayBasedShowFileHierarchyMetricsPresenter implements ShowFileHierarchyMetricsPresenter
{
    /**
     * @param Version $version
     * @return mixed
     */
    public function present(Version $version)
    {
        return json_encode(parent::present($version));
    }
}
