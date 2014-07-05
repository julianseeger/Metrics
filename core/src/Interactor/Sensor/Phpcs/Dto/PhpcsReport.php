<?php

namespace Metrics\Core\Interactor\Sensor\Phpcs\Dto;

class PhpcsReport
{
    /**
     * @var PhpcsFile[]
     */
    public $files = [];

    public static function parse(\SimpleXMLElement $element)
    {
        $report = new PhpcsReport();

        if (isset($element->file)) {
            foreach ($element->file as $file) {
                $report->files[] = PhpcsFile::parse($file);
            }
        }

        return $report;
    }
}
