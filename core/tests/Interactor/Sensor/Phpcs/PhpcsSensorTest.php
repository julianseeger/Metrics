<?php

namespace Interactor\Sensor\Phpcs;

use Metrics\Core\Entity\DirectoryVersion;
use Metrics\Core\Entity\MaterialType;
use Metrics\Core\Entity\Project;
use Metrics\Core\Entity\Version;
use Metrics\Core\Interactor\Sensor\Phpcs\PhpcsSensor;
use Metrics\Core\Repository\FileRepository;
use Metrics\Core\Repository\FileRepositoryMock;
use Metrics\Core\Repository\FileVersionRepositoryMock;
use Metrics\Core\Repository\MetricRepository;
use Metrics\Core\Repository\FileVersionRepository;
use Metrics\Core\Repository\MetricRepositoryMock;

class PhpcsSensorTest extends \PHPUnit_Framework_TestCase
{
    private $fixture = <<<'FIXTURE'
<?xml version="1.0" encoding="UTF-8"?>
<phpcs version="1.5.3">
<file name="/home/julian/PhpstormProjects/ASD/migrations/deltas/Version20140515175057.php"
 errors="8" warnings="1">
 <error line="15" column="16" source="PSR2.Methods.FunctionCallSignature.ContentAfterOpenBracket"
  severity="5">Opening parenthesis of a multi-line function call must be the last content on the line</error>
 <error line="366" column="10" source="PSR2.Methods.FunctionCallSignature.CloseBracketLine"
  severity="5">Closing parenthesis of a multi-line function call must be on a line by itself</error>
 <error line="368" column="16" source="PSR2.Methods.FunctionCallSignature.ContentAfterOpenBracket"
  severity="5">Opening parenthesis of a multi-line function call must be the last content on the line</error>
 <error line="376" column="10" source="PSR2.Methods.FunctionCallSignature.CloseBracketLine"
  severity="5">Closing parenthesis of a multi-line function call must be on a line by itself</error>
 <error line="378" column="16" source="PSR2.Methods.FunctionCallSignature.ContentAfterOpenBracket"
  severity="5">Opening parenthesis of a multi-line function call must be the last content on the line</error>
 <error line="397" column="10" source="PSR2.Methods.FunctionCallSignature.CloseBracketLine"
  severity="5">Closing parenthesis of a multi-line function call must be on a line by itself</error>
 <error line="399" column="16" source="PSR2.Methods.FunctionCallSignature.ContentAfterOpenBracket"
  severity="5">Opening parenthesis of a multi-line function call must be the last content on the line</error>
 <warning line="400" column="1" source="Generic.Files.LineLength.TooLong"
  severity="5">Line exceeds 120 characters; contains 262 characters</warning>
 <error line="401" column="10" source="PSR2.Methods.FunctionCallSignature.CloseBracketLine"
 severity="5">Closing parenthesis of a multi-line function call must be on a line by itself</error>
</file>
<file name="/home/julian/PhpstormProjects/ASD/something/Version20140613103354.php"
 errors="4" warnings="0">
 <error line="15" column="16" source="PSR2.Methods.FunctionCallSignature.ContentAfterOpenBracket"
  severity="5">Opening parenthesis of a multi-line function call must be the last content on the line</error>
 <error line="18" column="10" source="PSR2.Methods.FunctionCallSignature.CloseBracketLine"
  severity="5">Closing parenthesis of a multi-line function call must be on a line by itself</error>
 <error line="19" column="16" source="PSR2.Methods.FunctionCallSignature.ContentAfterOpenBracket"
  severity="5">Opening parenthesis of a multi-line function call must be the last content on the line</error>
 <error line="22" column="10" source="PSR2.Methods.FunctionCallSignature.CloseBracketLine"
  severity="5">Closing parenthesis of a multi-line function call must be on a line by itself</error>
</file>
</phpcs>
FIXTURE;

    /**
     * @var Project
     */
    private $project;

    /**
     * @var Version
     */
    private $version;

    /**
     * @var MetricRepository
     */
    private $metricsRepository;
    /**
     * @var FileRepository
     */
    private $fileRepository;
    /**
     * @var FileVersionRepository
     */
    private $fileVersionRepository;

    protected function setUp()
    {
        parent::setUp();
        $this->metricsRepository = new MetricRepositoryMock();
        $this->fileRepository = new FileRepositoryMock();
        $this->fileVersionRepository = new FileVersionRepositoryMock();
        $this->project = new Project("test");
        $this->version = new Version("1", $this->project);
    }

    public function testMetricIsRegistered()
    {
        $sensor = new PhpcsSensor($this->fileRepository, $this->fileVersionRepository, $this->metricsRepository);
        $sensor->execute($this->fixture, $this->project, $this->version);

        $this->assertGreaterThan(0, count($this->metricsRepository->getMetrics()));
        $metric = $this->metricsRepository->getMetric(PhpcsSensor::VIOLATIONS_METRIC_NAME);
        $this->assertFalse($metric->isInternal());
        $this->assertFalse($metric->isPercentaged());
    }

    public function testSupportsOnlyPhpcs()
    {
        $sensor = new PhpcsSensor($this->fileRepository, $this->fileVersionRepository, $this->metricsRepository);
        $this->assertTrue($sensor->supportsMaterialType(new MaterialType('phpcs')));
        $this->assertFalse($sensor->supportsMaterialType(new MaterialType('clover')));
    }

    public function testAttachesIssueCountToFilesAndFolders()
    {
        $sensor = new PhpcsSensor($this->fileRepository, $this->fileVersionRepository, $this->metricsRepository);
        $sensor->execute($this->fixture, $this->project, $this->version);

        $root = $this->version->getRoot();
        $this->assertNotNull($root);
        $this->assertTrue($root->hasFile('migrations'));
        /** @var DirectoryVersion $directory */
        $directory = $root->getFile('migrations');
        $violationsMetric = $this->metricsRepository->getMetric(PhpcsSensor::VIOLATIONS_METRIC_NAME);
        $this->assertEquals(9, $directory->getMetricValue($violationsMetric));
    }
}
