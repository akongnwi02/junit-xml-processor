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
                            'feature' => 'test report user can access and download submission report',
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
                            'feature' => 'test report user can access and download performance report',
                            'assertions' => 0,
                            'time' => 0.000038
                        )
                    ),
                    array(
                        '@attributes' => array(
                            'file' => '/app/tests/bom/170_ReportService/AccessReportServiceCest.php',
                            'name' => 'testReportUserCanAccessAndDownloadPaymentReport',
                            'class' => 'AccessReportServiceCest',
                            'feature' => 'test report user can access and download payment report',
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
                            'feature' => 'test report user can access and download progression report',
                            'assertions' => 1,
                            'time' => 0.006918
                        ),
                        'failure' => array(
                            '@content' => 'AccessReportServiceCest: Test report user can access and download progression report
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
        $attributeProcessor = new TestFormatter();
        $this->assertEquals(
            array(
                array(
                    'category' => 'Report Service',
                    'subCategory' => 'Access Report Service',
                    'component' => 'BOM',
                    'signature' => '/app/tests/bom/170_ReportService/AccessReportServiceCest.php:testReportUserCanAccessAndDownloadSubmissionReport',
                    'case' => 'Test report user can access and download submission report',
                    'status' => 'SKIPPED',
                    'time' => 0.000000,
                    'assertions' => 0
                ),
                array(
                    'category' => 'Report Service',
                    'subCategory' => 'Access Report Service',
                    'component' => 'BOM',
                    'signature' => '/app/tests/bom/170_ReportService/AccessReportServiceCest.php:testReportUserCanAccessAndDownloadPerformanceReport',
                    'case' => 'Test report user can access and download performance report',
                    'status' => 'PASSED',
                    'time' => 0.000038,
                    'assertions' => 0
                ),
                array(
                    'category' => 'Report Service',
                    'subCategory' => 'Access Report Service',
                    'component' => 'BOM',
                    'signature' => '/app/tests/bom/170_ReportService/AccessReportServiceCest.php:testReportUserCanAccessAndDownloadPaymentReport',
                    'case' => 'Test report user can access and download payment report',
                    'status' => 'SKIPPED',
                    'time' => 0.0,
                    'assertions' => 0
                ),
                array(
                    'category' => 'Report Service',
                    'subCategory' => 'Access Report Service',
                    'component' => 'BOM',
                    'signature' => '/app/tests/bom/170_ReportService/AccessReportServiceCest.php:testReportUserCanAccessAndDownloadProgressionReport',
                    'case' => 'Test report user can access and download progression report',
                    'status' => 'FAILED',
                    'time' => 0.006918,
                    'assertions' => 1
                )
            ),
            $attributeProcessor->process($this->attributes)
        );
    }
}