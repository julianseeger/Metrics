<?php

namespace Metrics\Core\Interactor\Sensor\Clover\Dto;

trait HasMetrics
{
    /**
     * @var Metrics
     */
    public $metrics;

    public function parseMetrics(\SimpleXMLElement $element)
    {
        if (!isset($element->metrics)) {
            return;
        }

        $this->metrics = Metrics::parse($element->metrics);
    }
}
 