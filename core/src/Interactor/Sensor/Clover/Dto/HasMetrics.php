<?php

namespace Metrics\Core\Interactor\Sensor\Clover\Dto;

trait HasMetrics
{
    public $metrics;

    public function parseMetrics(\SimpleXMLElement $element)
    {
        if (!isset($element->metrics)) {
            return;
        }

        $this->metrics = Metrics::parse($element->metrics);
    }
}
 