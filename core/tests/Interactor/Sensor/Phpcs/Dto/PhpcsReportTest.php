<?php

namespace Interactor\Sensor\Phpcs\Dto;

use Metrics\Core\Interactor\Sensor\Phpcs\Dto\PhpcsReport;

class PhpcsReportTest extends \PHPUnit_Framework_TestCase
{
    private $fixture = <<<'FIXTURE'
<?xml version="1.0" encoding="UTF-8"?>
<phpcs version="1.5.3">
<file name="/home/julian/PhpstormProjects/asd/migrations/deltas/Version20140515175057.php"
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
<file name="/home/julian/PhpstormProjects/asd/migrations/deltas/Version20140613103354.php"
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

    public function testFileParser()
    {
        $report = PhpcsReport::parse(simplexml_load_string($this->fixture));

        $this->assertEquals(2, count($report->files));
        $file = $report->files[0];
        $this->assertEquals(
            '/home/julian/PhpstormProjects/Best-AskSmart/migrations/deltas/Version20140515175057.php',
            $file->name
        );
        $this->assertEquals(
            '/home/julian/PhpstormProjects/Best-AskSmart/migrations/deltas/Version20140613103354.php',
            $report->files[1]->name
        );

        $this->assertEquals(8, $file->errorCount);
        $this->assertEquals(1, $file->warningCount);
    }

    public function testIssueParser()
    {
        $report = PhpcsReport::parse(simplexml_load_string($this->fixture));
        $file = $report->files[0];

        $this->assertEquals(8, count($file->errors));
        $this->assertEquals(1, count($file->warnings));

        $error = $file->errors[0];
        $this->assertEquals(15, $error->line);
        $this->assertEquals(16, $error->column);
        $this->assertEquals(5, $error->severity);
        $this->assertEquals("PSR2.Methods.FunctionCallSignature.ContentAfterOpenBracket", $error->source);
        $this->assertEquals(
            "Opening parenthesis of a multi-line function call must be the last content on the line",
            $error->message
        );
    }
}
