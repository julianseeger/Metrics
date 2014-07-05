<?php

namespace Metrics\Core\Interactor\Sensor\Phpcs\Dto;

class PhpcsError extends PhpcsIssue
{
    public static function parse(\SimpleXMLElement $element)
    {
        return parent::parse(new PhpcsWarning(), $element);
    }
}
