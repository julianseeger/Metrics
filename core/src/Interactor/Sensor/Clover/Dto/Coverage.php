<?php

namespace Metrics\Core\Interactor\Sensor\Clover\Dto;

class Coverage
{
    /**
     * @var Project[]
     */
    public $projects = [];

    public static function parse(\SimpleXMLElement $element)
    {
        $coverage = new Coverage();
        if (isset($element->project)) {
            if (isset($element->project[0])) {
                for ($i = 0; isset($element->project[$i]); $i++) {
                    $coverage->projects[] = Project::parse($element->project[$i]);
                }
            } else {
                $coverage->projects[] = Project::parse($element->project);
            }
        }
        return $coverage;
    }
}
 