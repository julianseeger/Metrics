<?php

namespace Metrics\Core\Interactor\Sensor\Phpcs\Dto;

class PhpcsFile
{
    /**
     * @var PhpcsError[]
     */
    public $errors = [];

    /**
     * @var PhpcsWarning[]
     */
    public $warnings = [];

    public $errorCount = 0;
    public $warningCount = 0;

    public $name;

    public static function parse(\SimpleXMLElement $element)
    {
        $file = new PhpcsFile();
        $file->name = (string)$element->attributes()->name;
        $file->errorCount = (int)(string)$element->attributes()->errors;
        $file->warningCount = (int)(string)$element->attributes()->warnings;

        if (isset($element->error)) {
            foreach ($element->error as $error) {
                $file->errors[] = PhpcsError::parse($error);
            }
        }

        if (isset($element->warning)) {
            foreach ($element->warning as $warning) {
                $file->warnings[] = PhpcsWarning::parse($warning);
            }
        }

        return $file;
    }
}
