<?php

namespace Metrics\Core\Presenter\ArrayBased;

use Metrics\Core\Entity\Metric;
use Metrics\Core\Entity\Project;
use Metrics\Core\Entity\Version;
use Metrics\Core\ViewDto\ShowTimeSeriesResult;

class ArrayBasedShowTimeSeriesPresenterTest extends \PHPUnit_Framework_TestCase
{
    public function testPresentsMetric()
    {
        $metric = new Metric('coverage');
        $result = new ShowTimeSeriesResult($metric);

        $presenter = new ArrayBasedShowTimeSeriesPresenter();
        $presentation = $presenter->present($result);
        $this->assertEquals(
            [
                'name' => 'coverage',
                'isPercentaged' => false,
                'isInternal' => false
            ],
            $presentation['metric']
        );
    }

    public function testPresentsVersions()
    {
        $project = new Project('testproject');
        $metric = new Metric('coverage');
        $result = new ShowTimeSeriesResult($metric);
        $result->addValue(new Version('1', $project), 11);
        $result->addValue(new Version('2', $project), 22);

        $presenter = new ArrayBasedShowTimeSeriesPresenter();
        $presentation = $presenter->present($result);

        $this->assertEquals([['label' => '1'], ['label' => '2']], $presentation['versions']);
    }

    public function testPresentsMetricValues()
    {
        $project = new Project('testproject');
        $metric = new Metric('coverage');
        $result = new ShowTimeSeriesResult($metric);
        $result->addValue(new Version('1', $project), 11);
        $result->addValue(new Version('2', $project), 22);

        $presenter = new ArrayBasedShowTimeSeriesPresenter();
        $presentation = $presenter->present($result);

        $this->assertEquals(11, $presentation['values']['1']);
        $this->assertEquals(22, $presentation['values']['2']);
    }
}
