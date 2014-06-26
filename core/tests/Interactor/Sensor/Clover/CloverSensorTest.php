<?php

namespace Metrics\Core\Interactor\Sensor\Clover;

use Metrics\Core\Entity\Directory;
use Metrics\Core\Entity\FileVersion;
use Metrics\Core\Entity\Metric;
use Metrics\Core\Entity\Project;
use Metrics\Core\Repository\FileRepositoryMock;
use Metrics\Core\Repository\FileVersionRepositoryMock;
use Metrics\Core\Repository\MetricRepositoryMock;
use Metrics\Core\Repository\VersionRepositoryMock;

class CloverSensorTest extends \PHPUnit_Framework_TestCase
{
    const FIXTURE = '<?xml version="1.0" encoding="UTF-8"?>
<coverage generated="1402691128">
    <project timestamp="1402691128">
        <package name="Bws\Entity">
            <file name="/Applications/XAMPP/xamppfiles/htdocs/shop/src/Bws/Entity/Article.php">
                <class name="Article" namespace="Bws\Entity">
                    <metrics methods="12" coveredmethods="12" conditionals="0" coveredconditionals="0"
                    statements="18" coveredstatements="18" elements="30" coveredelements="30"/>
                </class>
                <line num="47" type="method" name="setEan" crap="1" count="25"/>
                <metrics loc="175" ncloc="91" classes="1" methods="12" coveredmethods="12" conditionals="0"
                coveredconditionals="0" statements="18" coveredstatements="18" elements="30" coveredelements="30"/>
            </file>
            <file name="/Applications/XAMPP/xamppfiles/htdocs/shop/src/BwsShop/SomePackage/SomeClass.php">
                <class name="SomeClass" namespace="BwsShop\SomePackage">
                    <metrics methods="2" coveredmethods="2" conditionals="0" coveredconditionals="0" statements="4"
                    coveredstatements="2" elements="5" coveredelements="5"/>
                </class>
                <line num="20" type="method" name="getId" crap="1" count="19"/>
                <line num="22" type="stmt" count="19"/>
                <line num="28" type="method" name="setId" crap="1" count="19"/>
                <line num="30" type="stmt" count="19"/>
                <line num="31" type="stmt" count="19"/>
                <line num="33" type="stmt" count="1"/>
                <metrics loc="32" ncloc="18" classes="1" methods="2" coveredmethods="2" conditionals="0"
                coveredconditionals="0" statements="4" coveredstatements="2" elements="5" coveredelements="5"/>
            </file>
            <file name="/Applications/XAMPP/xamppfiles/htdocs/shop/src/BwsShop/SomePackage/SomeCoveredClass.php">
                <class name="SomeCoveredClass" namespace="BwsShop\SomePackage">
                    <metrics methods="2" coveredmethods="2" conditionals="0" coveredconditionals="0" statements="3"
                    coveredstatements="3" elements="5" coveredelements="5"/>
                </class>
                <line num="20" type="method" name="getId" crap="1" count="19"/>
                <line num="22" type="stmt" count="19"/>
                <line num="28" type="method" name="setId" crap="1" count="19"/>
                <line num="30" type="stmt" count="19"/>
                <line num="31" type="stmt" count="19"/>
                <line num="33" type="stmt" count="1"/>
                <metrics loc="32" ncloc="18" classes="1" methods="2" coveredmethods="2" conditionals="0"
                coveredconditionals="0" statements="3" coveredstatements="3" elements="5" coveredelements="5"/>
            </file>
        </package>
        <metrics files="39" loc="2409" ncloc="1510" classes="31" methods="137" coveredmethods="137" conditionals="0"
        coveredconditionals="0" statements="369" coveredstatements="369" elements="506" coveredelements="506"/>
    </project>
</coverage>';

    public function testFileHierarchyGeneration()
    {
        $project = new Project('testproject');
        $versionRepository = new VersionRepositoryMock();
        $version = $versionRepository->create($project, "0.1");
        $fileRepository = new FileRepositoryMock();
        $fileVersionRepository = new FileVersionRepositoryMock();
        $metricRepository = new MetricRepositoryMock();
        $sensor = new CloverSensor($fileRepository, $fileVersionRepository, $metricRepository);

        $sensor->execute(self::FIXTURE, $project, $version);

        $this->assertEquals(2, count($project->getRoot()->getFiles()));
        $this->assertTrue($project->getRoot()->hasFile('Bws'));
        $this->assertTrue($project->getRoot()->hasFile('BwsShop'));

        /** @var Directory $bws */
        $bws = $project->getRoot()->getFile('Bws');
        $this->assertInstanceOf('Metrics\Core\Entity\Directory', $bws);
        $this->assertTrue($bws->hasFile('Entity'));

        /** @var Directory $bwsEntity */
        $bwsEntity = $bws->getFile('Entity');
        $this->assertInstanceOf('Metrics\Core\Entity\Directory', $bwsEntity);
        $this->assertTrue($bwsEntity->hasFile('Article.php'));

        $article = $bwsEntity->getFile('Article.php');
        $this->assertEquals('Bws\Entity', $article->getNamespace());
        $this->assertEquals('Article', $article->getClassname());
    }

    public function testFileVersionHierarchyGeneration()
    {
        $project = new Project('testproject');
        $versionRepository = new VersionRepositoryMock();
        $version = $versionRepository->create($project, "0.1");
        $fileRepository = new FileRepositoryMock();
        $fileVersionRepository = new FileVersionRepositoryMock();
        $metricRepository = new MetricRepositoryMock();
        $sensor = new CloverSensor($fileRepository, $fileVersionRepository, $metricRepository);

        $sensor->execute(self::FIXTURE, $project, $version);

        $this->assertEquals(2, count($version->getRoot()->getFiles()));
        $this->assertTrue($version->getRoot()->hasFile('Bws'));
        $this->assertTrue($version->getRoot()->hasFile('BwsShop'));

        /** @var Directory $bws */
        $bws = $version->getRoot()->getFile('Bws');
        $this->assertInstanceOf('Metrics\Core\Entity\DirectoryVersion', $bws);
        $this->assertTrue($bws->hasFile('Entity'));

        /** @var Directory $bwsEntity */
        $bwsEntity = $bws->getFile('Entity');
        $this->assertInstanceOf('Metrics\Core\Entity\DirectoryVersion', $bwsEntity);
        $this->assertTrue($bwsEntity->hasFile('Article.php'));

        $article = $bwsEntity->getFile('Article.php');
        $this->assertInstanceOf('Metrics\Core\Entity\FileVersion', $article);
        $this->assertEquals('Bws\Entity', $article->getNamespace());
        $this->assertEquals('Article', $article->getClassname());
    }

    public function testAttachesMetricsOnFileLevel()
    {
        $project = new Project('testproject');
        $versionRepository = new VersionRepositoryMock();
        $version = $versionRepository->create($project, "0.1");
        $fileRepository = new FileRepositoryMock();
        $fileVersionRepository = new FileVersionRepositoryMock();
        $metricRepository = new MetricRepositoryMock();
        $sensor = new CloverSensor($fileRepository, $fileVersionRepository, $metricRepository);

        $sensor->execute(self::FIXTURE, $project, $version);

        /** @var FileVersion $file */
        $file = $version->getRoot()->getFile('Bws')->getFile('Entity')->getFile('Article.php');
        $this->assertEquals(1, $file->getMetricValue(new Metric(Metric::LINE_COVERAGE)));
    }

    public function testAttachesMetricsOnProjectLevel()
    {
        $project = new Project('testproject');
        $versionRepository = new VersionRepositoryMock();
        $version = $versionRepository->create($project, "0.1");
        $fileRepository = new FileRepositoryMock();
        $fileVersionRepository = new FileVersionRepositoryMock();
        $metricRepository = new MetricRepositoryMock();
        $sensor = new CloverSensor($fileRepository, $fileVersionRepository, $metricRepository);

        $sensor->execute(self::FIXTURE, $project, $version);

        /** @var FileVersion $file */
        $file = $version->getRoot();
        $this->assertEquals(1, $file->getMetricValue(new Metric(Metric::LINE_COVERAGE)));
    }

    public function testAttachesMetricsOnDirectoryLevel()
    {
        $project = new Project('testproject');
        $versionRepository = new VersionRepositoryMock();
        $version = $versionRepository->create($project, "0.1");
        $fileRepository = new FileRepositoryMock();
        $fileVersionRepository = new FileVersionRepositoryMock();
        $metricRepository = new MetricRepositoryMock();
        $sensor = new CloverSensor($fileRepository, $fileVersionRepository, $metricRepository);

        $sensor->execute(self::FIXTURE, $project, $version);

        /** @var FileVersion $file */
        $file = $version->getRoot()->getFile('BwsShop');
        $this->assertEquals(0.714, $file->getMetricValue(new Metric(Metric::LINE_COVERAGE)), "fail", 0.001);
    }

    public function testRegistersItsMetrics()
    {
        $project = new Project('testproject');
        $versionRepository = new VersionRepositoryMock();
        $version = $versionRepository->create($project, "0.1");
        $fileRepository = new FileRepositoryMock();
        $fileVersionRepository = new FileVersionRepositoryMock();
        $metricRepository = new MetricRepositoryMock();
        $sensor = new CloverSensor($fileRepository, $fileVersionRepository, $metricRepository);

        $sensor->execute(self::FIXTURE, $project, $version);

        $metrics = $metricRepository->getMetrics();
        $this->assertEquals(3, count($metrics));
        $this->assertTrue(isset($metrics['coverage']));
        $this->assertTrue(isset($metrics['statements']));
        $this->assertTrue(isset($metrics['coveredstatements']));

        $coverage = $metrics['coverage'];
        $this->assertTrue($coverage->isPercentaged());
        $this->assertFalse($coverage->isInternal());

        $statements = $metrics['statements'];
        $this->assertFalse($statements->isPercentaged());
        $this->assertTrue($statements->isInternal());

        $coveredstatements = $metrics['coveredstatements'];
        $this->assertFalse($coveredstatements->isPercentaged());
        $this->assertTrue($coveredstatements->isInternal());
    }
}
