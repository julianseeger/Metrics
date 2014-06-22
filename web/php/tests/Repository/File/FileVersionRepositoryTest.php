<?php

namespace Metrics\Web\Repository\File;

use Metrics\Core\Entity\Project;
use Metrics\Core\Entity\Version;

class FileVersionRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $directory;

    protected function setUp()
    {
        $this->directory = '/tmp/metricstest' . microtime(true) . mt_rand(0, 99999);
        mkdir($this->directory);
    }

    public function testPersistsObjects()
    {
        $repo1 = new FileVersionRepository($this->directory);
        $project = new Project("testproject");
        $versions = [
            $repo1->create($project, "a"),
            $repo1->create($project, "b")
        ];

        $repo2 = new FileVersionRepository($this->directory);
        $this->assertEquals($versions, $repo2->findAll($project));

        $version3 = $repo1->create($project, "c");
        $versions[] = $version3;
        $this->assertEquals($versions, $repo2->findAll($project));
    }

    public function testFindOne()
    {
        $repo = new FileVersionRepository($this->directory);
        $project = new Project("testproject");
        $version = $repo->create($project, "testlabel");

        $this->assertEquals($version, $repo->findOne($project, "testlabel"));
    }

    protected function tearDown()
    {
        $files = glob($this->directory . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                if (!unlink($file)) {
                    throw new \Exception("failed to unlink file " . $file . " at tearDown");
                }
            }
        }
        rmdir($this->directory);
    }
}
