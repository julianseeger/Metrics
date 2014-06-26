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
     * @var bool
     */
    private $percentaged = false;

    /**
     * @var bool
     */
    private $internal = false;

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

    /**
     * @param bool $percentaged
     */
    public function setPercentaged($percentaged = true)
    {
        $this->percentaged = $percentaged;
    }

    /**
     * @return bool
     */
    public function isPercentaged()
    {
        return $this->percentaged;
    }

    /**
     * @param bool $internal
     */
    public function setInternal($internal = true)
    {
        $this->internal = $internal;
    }

    /**
     * @return bool
     */
    public function isInternal()
    {
        return $this->internal;
    }
}
