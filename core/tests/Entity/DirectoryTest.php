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

    public function testFileAssociation()
    {
        $directory = new Directory('/');
        $file = new File('test.php');

        $this->assertFalse($directory->hasFile('test.php'));
        $directory->addFile($file);

        $this->assertTrue($directory->hasFile('test.php'));
        $this->assertSame($file, $directory->getFile('test.php'));
    }

    public function testFilenameOverwrite()
    {
        $directory = new Directory('/');
        $file1 = new File('test.php');
        $file2 = new File('test.php');

        $directory->addFile($file1);
        $directory->addFile($file2);

        $this->assertSame($file2, $directory->getFile('test.php'));
        $this->assertNotSame($file1, $directory->getFile('test.php'));
    }

    public function testPathResolution()
    {
        $directory1 = new Directory('');
        $directory2 = new Directory('Somewhere');
        $directory3 = new Directory('Deep');

        $file = new File('test.php');

        $directory1->addFile($directory2);
        $directory2->addFile($directory3);
        $directory3->addFile($file);

        $this->assertEquals('/Somewhere/Deep/test.php', $file->getPath());
    }
}
