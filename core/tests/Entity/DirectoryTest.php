<?php

namespace Metrics\Core\Entity;

class DirectoryTest extends \PHPUnit_Framework_TestCase
{
    public function testAddFileSetsParent()
    {
        $directory = new Directory('/');
        $file = new File('test.php');

        $directory->addFile($file);

        $this->assertEquals($directory, $file->getParent());
        $this->assertContains($file, $directory->getFiles());
    }
}
