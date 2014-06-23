<?php

namespace Metrics\Core\Interactor\Sensor\Clover\Dto;

trait HasFiles
{
    /**
     * @var File[]
     */
    public $file = [];

    public function parseFiles(\SimpleXMLElement $element)
    {
        if (isset($element->file)) {
            if (isset($element->file[0])) {
                for ($i = 0; isset($element->file[$i]); $i++) {
                    $this->file[] = File::parse($element->file[$i]);
                }
            } else {
                $this->file[] = File::parse($element->file);
            }
        }
    }
}
