<?php

namespace Metrics\Core\Entity;

class FileVersionTest extends \PHPUnit_Framework_TestCase
{
    public function testMetrics()
    {
        $file = new FileVersion('test');
        $file->addMetricValue(new Metric(Metric::LINE_COVERAGE), 1);
        $this->assertEquals(1, $file->getMetricValue(new Metric(Metric::LINE_COVERAGE)));
    }
}
