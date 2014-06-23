<?php

namespace Metrics\Core\Interactor\Sensor\Clover\Dto;

class Metrics
{
    public $loc;
    public $ncloc;
    public $classes;
    public $methods;
    public $coveredmethods;
    public $conditionals;
    public $coveredconditionals;
    public $statements;
    public $coveredstatements;
    public $elements;
    public $coveredelements;

    public static function parse(\SimpleXMLElement $element)
    {
        $metrics = new Metrics();

        $metrics->parseIfExists($element, 'loc');
        $metrics->parseIfExists($element, 'ncloc');
        $metrics->parseIfExists($element, 'classes');
        $metrics->parseIfExists($element, 'methods');
        $metrics->parseIfExists($element, 'coveredmethods');
        $metrics->parseIfExists($element, 'conditionals');
        $metrics->parseIfExists($element, 'coveredconditionals');
        $metrics->parseIfExists($element, 'statements');
        $metrics->parseIfExists($element, 'coveredstatements');
        $metrics->parseIfExists($element, 'elements');
        $metrics->parseIfExists($element, 'coveredelements');

        return $metrics;
    }

    public function parseIfExists(\SimpleXMLElement $element, $propertyname)
    {
        $attributes = $element->attributes();
        if (isset($attributes->$propertyname)) {
            $this->$propertyname = (int)$attributes->$propertyname;
        }
    }
}
