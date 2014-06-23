<?php

namespace Metrics\Core\Repository;

use Metrics\Core\Entity\Directory;
use Metrics\Core\Entity\Project;

class AbstractFileRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreatesSimpleDirectory()
    {
        $project = new Project("test");
        $root = new Directory("");
        $project->setRoot($root);
        $repo = new FileRepositoryMock();

        $dir = $repo->createDirectory("someDirInRoot", $project);

        $this->assertContains($dir, $root->getFiles());
    }

    public function testCreatesImplicitRootDirectory()
    {
        $project = new Project("test");
        $repo = new FileRepositoryMock();

        $dir = $repo->createDirectory("someDirInRoot", $project);

        $this->assertNotNull($project->getRoot());
        $this->assertContains($dir, $project->getRoot()->getFiles());
    }

    public function testCreatesDirectoryStructure()
    {
        $project = new Project("test");
        $repo = new FileRepositoryMock();

        $dir = $repo->createDirectory("some/subdir", $project);

        $this->assertEquals("subdir", $dir->getName());
        $rootFiles = $project->getRoot()->getFiles();
        $this->assertEquals(1, count($rootFiles));

        /** @var Directory $intermediateDirectory */
        $intermediateDirectory = $rootFiles[0];
        $this->assertEquals("some", $intermediateDirectory->getName());
        $this->assertContains($dir, $intermediateDirectory->getFiles());
    }

    public function testTrimsSlashes()
    {
        $project = new Project("test");
        $repo = new FileRepositoryMock();

        $dir = $repo->createDirectory('/dirWithSlashes/', $project);

        $this->assertEquals('dirWithSlashes', $dir->getName());
        $this->assertContains($dir, $project->getRoot()->getFiles());
    }

    public function testFilesHaveTheCorrectClass()
    {
        $project = new Project("test");
        $repo = new FileRepositoryMock();

        $file = $repo->createFile('someFile', $project);

        $this->assertInstanceOf('\Metrics\Core\Entity\File', $file);
    }

    public function testFilesAreCreatedInDirectories()
    {

        $project = new Project("test");
        $repo = new FileRepositoryMock();

        $file = $repo->createFile('someFile', $project);

        $this->assertContains($file, $project->getRoot()->getFiles());
    }


    public function testFilesAreCreatedWithDeepDirectoryStructure()
    {

        $project = new Project("test");
        $repo = new FileRepositoryMock();

        $file = $repo->createFile('/some/where/file', $project);

        /** @var Directory $some */
        $some = $project->getRoot()->getFiles()[0];
        $this->assertEquals('some', $some->getName());

        /** @var Directory $where */
        $where = $some->getFiles()[0];
        $this->assertEquals('where', $where->getName());
        $this->assertContains($file, $where->getFiles());
    }
}
