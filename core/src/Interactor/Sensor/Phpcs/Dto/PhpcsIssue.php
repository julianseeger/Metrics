<?php

namespace Metrics\Core\Interactor\Sensor\Phpcs\Dto;

abstract class PhpcsIssue
{
    public $line;
    public $column;
    public $source;
    public $severity;
    public $message;

    public static function parse(PhpcsIssue $instance, \SimpleXMLElement $element)
    {
        $instance->line = (int)(string)$element->attributes()->line;
        $instance->column = (int)(string)$element->attributes()->column;
        $instance->source = (string)$element->attributes()->source;
        $instance->severity = (int)(string)$element->attributes()->severity;
        $instance->message = (string)$element;
        return $instance;
    }
}
