<?php

namespace Metrics\Core\Presenter\ArrayBased;

use Metrics\Core\Entity\Metric;
use Metrics\Core\Entity\Version;
use Metrics\Core\Presenter\ShowTimeSeriesPresenter;
use Metrics\Core\ViewDto\ShowTimeSeriesResult;

class ArrayBasedShowTimeSeriesPresenter implements ShowTimeSeriesPresenter
{
    public function present(ShowTimeSeriesResult $result)
    {
        return [
            'metric' => $this->presentMetric($result->getMetric()),
            'versions' => $this->presentVersions($result->getVersions()),
            'values' => $this->presentValues($result)
        ];
    }

    private function presentMetric(Metric $metric)
    {
        return [
            'name' => $metric->getName(),
            'isPercentaged' => $metric->isPercentaged(),
            'isInternal' => $metric->isInternal()
        ];
    }

    /**
     * @param Version[] $versions
     * @return array
     */
    private function presentVersions($versions)
    {
        $presentation = [];
        foreach ($versions as $version) {
            $presentation[] = $this->presentVersion($version);
        }
        return $presentation;
    }

    private function presentVersion(Version $version)
    {
        return [
            'label' => $version->getLabel()
        ];
    }

    private function presentValues(ShowTimeSeriesResult $result)
    {
        $values = [];

        foreach ($result->getVersions() as $version) {
            $values[$version->getLabel()] = $result->getValue($version);
        }

        return $values;
    }
}
