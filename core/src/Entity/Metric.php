<?php

namespace Metrics\Core\Entity;

class Metric
{
    const LINE_COVERAGE = 'coverage';
    const BRANCH_COVERAGE = 'branchCoverage';
    const LINES_OF_CODE = 'loc';
    const NON_COMMENT_LINES_OF_CODE = 'ncloc';

    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
