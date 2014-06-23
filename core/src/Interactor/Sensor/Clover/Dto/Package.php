<?php

namespace Metrics\Core\Interactor\Sensor\Clover\Dto;

class Package
{
    use HasFiles;

    public $name;

    public static function parse(\SimpleXMLElement $element)
    {
        $package = new Package();

        $package->name = (string)$element->attributes()->name;

        $package->parseFiles($element);

        return $package;
    }
}
