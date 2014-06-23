<?php

namespace Metrics\Core\Interactor\Sensor\Clover\Dto;

class ClassElement
{
    use HasMetrics;

    public $name;
    public $namespace;

    public static function parse(\SimpleXMLElement $element)
    {
        $class = new ClassElement();
        $class->name = (string)$element->attributes()->name;
        $class->namespace = (string)$element->attributes()->namespace;

        $class->parseMetrics($element);

        return $class;
    }
}
