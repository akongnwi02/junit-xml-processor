<?php
/**
 * Created by PhpStorm.
 * User: devert
 * Date: 2/27/19
 * Time: 12:48 AM
 */

namespace Devert\Feature;

use PHPUnit\Framework\TestCase;
use Devert\Util\TestFormatter;
class TestFormatterTest extends TestCase
{
    public $attributes;

    public function setUp() : void
    {
        $this->attributes = array(
            'testsuite' => array(
                '@attributes' => array(
                    'name' => 'bom',
                    'tests' => 4,
                    'assertions' => 1,
                    'errors' => 0,
                    'failures' => 1,
                    'skipped' => 2,
                    'time' => 0.006956
                ),
                'testcase' => array(
                    array(
                        '@attributes' => array(
                            'file' => '/app/tests/bom/170_ReportService/AccessReportServiceCest.php',
                            'name' => 'testReportUserCanAccessAndDownloadSubmissionReport',
                            'class' => 'AccessReportServiceCest',
                            'feature' => 'test report.php user can access and download submission report.php',
                            'assertions' => 0,
                            'time' => 0.000000
                        ),
                        'skipped' => array()
                    ),
                    array(
                        '@attributes' => array(
                            'file' => '/app/tests/bom/170_ReportService/AccessReportServiceCest.php',
                            'name' => 'testReportUserCanAccessAndDownloadPerformanceReport',
                            'class' => 'AccessReportServiceCest',
                            'feature' => 'test report.php user can access and download performance report.php',
                            'assertions' => 0,
                            'time' => 0.000038
                        )
                    ),
                    array(
                        '@attributes' => array(
                            'file' => '/app/tests/bom/170_ReportService/AccessReportServiceCest.php',
                            'name' => 'testReportUserCanAccessAndDownloadPaymentReport',
                            'class' => 'AccessReportServiceCest',
                            'feature' => 'test report.php user can access and download payment report.php',
                            'assertions' => 0,
                            'time' => 0.000000,
                        ),
                        'skipped' => array(),
                    ),
                    array(
                        '@attributes' => array(
                            'file' => '/app/tests/bom/170_ReportService/AccessReportServiceCest.php',
                            'name' => 'testReportUserCanAccessAndDownloadProgressionReport',
                            'class' => 'AccessReportServiceCest',
                            'feature' => 'test report.php user can access and download progression report.php',
                            'assertions' => 1,
                            'time' => 0.006918
                        ),
                        'failure' => array(
                            '@content' => 'AccessReportServiceCest: Test report.php user can access and download progression report.php
Failed asserting that 2 matches expected 1.

/app/tests/_support/_generated/BomTesterActions.php:42
/app/tests/bom/170_ReportService/AccessReportServiceCest.php:27',
                            '@attributes' => array(
                                'type' => 'PHPUnit\Framework\ExpectationFailedException'
                            )
                        ),
                    )
                )
            )
        );
    }

    public function testProcess()
    {
        $this->assertEquals(
            array(
                array(
                    'suite' => 'Bom',
                    'testcases' => array(
                        array(
                            'category' => 'Report Service',
                            'subCategory' => 'Access Report Service',
                            'component' => 'Bom',
                            'signature' => '/app/tests/bom/170_ReportService/AccessReportServiceCest.php:testReportUserCanAccessAndDownloadSubmissionReport',
                            'case' => 'Test report.php user can access and download submission report.php',
                            'status' => 'SKIPPED',
                            'time' => 0.000000,
                            'assertions' => 0
                        ),
                        array(
                            'category' => 'Report Service',
                            'subCategory' => 'Access Report Service',
                            'component' => 'Bom',
                            'signature' => '/app/tests/bom/170_ReportService/AccessReportServiceCest.php:testReportUserCanAccessAndDownloadPerformanceReport',
                            'case' => 'Test report.php user can access and download performance report.php',
                            'status' => 'SKIPPED',
                            'time' => 0.000038,
                            'assertions' => 0
                        ),
                        array(
                            'category' => 'Report Service',
                            'subCategory' => 'Access Report Service',
                            'component' => 'Bom',
                            'signature' => '/app/tests/bom/170_ReportService/AccessReportServiceCest.php:testReportUserCanAccessAndDownloadPaymentReport',
                            'case' => 'Test report.php user can access and download payment report.php',
                            'status' => 'SKIPPED',
                            'time' => 0.0,
                            'assertions' => 0
                        ),
                        array(
                            'category' => 'Report Service',
                            'subCategory' => 'Access Report Service',
                            'component' => 'Bom',
                            'signature' => '/app/tests/bom/170_ReportService/AccessReportServiceCest.php:testReportUserCanAccessAndDownloadProgressionReport',
                            'case' => 'Test report.php user can access and download progression report.php',
                            'status' => 'FAILED',
                            'time' => 0.006918,
                            'assertions' => 1
                        )
                    )
                )
            ),
            TestFormatter::process($this->attributes)
        );
    }
}