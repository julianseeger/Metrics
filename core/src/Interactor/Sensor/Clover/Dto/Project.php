<?php

namespace Metrics\Core\Interactor\Sensor\Clover\Dto;

class Project
{
    use HasFiles;

    /**
     * @var Package[]
     */
    public $packages = [];

    public static function parse(\SimpleXMLElement $element)
    {
        $project = new Project();

        if (isset($element->package)) {
            if (isset($element->package[0])) {
                for ($i = 0; isset($element->package[$i]); $i++) {
                    $project->packages[] = Package::parse($element->package[$i]);
                }
            } else {
                $project->packages[] = Package::parse($element->package);
            }
        }

        $project->parseFiles($element);

        return $project;
    }
}
 