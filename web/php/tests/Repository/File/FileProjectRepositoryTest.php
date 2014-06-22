<?php

namespace Metrics\Web\Repository\File;

use Metrics\Core\Entity\Project;

class FileProjectRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $directory;

    protected function setUp()
    {
        $this->directory = '/tmp/metricstest' . microtime(true) . mt_rand(0, 99999);
        mkdir($this->directory);
    }

    public function testPersistsObjects()
    {
        $repo1 = new FileProjectRepository($this->directory);
        $projects = [
            $repo1->create("a"),
            $repo1->create("b")
        ];

        $repo2 = new FileProjectRepository($this->directory);
        $this->assertEquals($projects, $repo2->findAll());

        $project3 = $repo1->create("c");
        $projects[] = $project3;
        $this->assertEquals($projects, $repo2->findAll());
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
