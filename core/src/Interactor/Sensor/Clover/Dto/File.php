<?php

namespace Metrics\Core\Interactor\Sensor\Clover\Dto;

class File
{
    use HasMetrics;

    public $name;

    /**
     * @var ClassElement
     */
    public $class;

    public static function parse(\SimpleXMLElement $element)
    {
        $file = new File();
        $file->name = (string)$element->attributes()->name;

        if (isset($element->class)) {
            $file->class = ClassElement::parse($element->class);
        }

        $file->parseMetrics($element);

        return $file;
    }
}
