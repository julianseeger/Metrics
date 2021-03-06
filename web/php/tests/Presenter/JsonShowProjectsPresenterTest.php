<?php

namespace Metrics\Web\Presenter;

use Metrics\Core\Entity\Project;

class JsonShowProjectsPresenterTest extends \PHPUnit_Framework_TestCase
{
    public function testProducesJsonObject()
    {
        $presenter = new JsonShowProjectsPresenter();
        $project = new Project("a");
        $project->setName('testproject');

        $this->assertEquals('[{"name":"testproject"}]', $presenter->present([$project]));
    }
}
