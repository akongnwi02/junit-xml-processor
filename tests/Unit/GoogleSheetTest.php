<?php
/**
 * Created by PhpStorm.
 * User: devert
 * Date: 3/8/19
 * Time: 11:39 PM
 */

namespace Devert\Unit;


use Devert\Util\GoogleSheet;
use PHPUnit\Framework\TestCase;

class GoogleSheetTest extends TestCase
{
    /**
     * @var GoogleSheet
     */
    protected $googleSheet;
    public function setUp()
    {
        $this->googleSheet = new GoogleSheet('fake-credentials');
    }
    public function testGetDataSuccessfully()
    {
        $range = 'BomA2:B';
        $dimension = 'ROWS';
        $runNumber = 1;
        $suite = array(
            array(
                'category' => 'Report Service',
                'subCategory' => 'Access Report Service',
                'component' => 'Bom',
                'signature' => '/app/tests/bom/170_ReportService/AccessReportServiceCest:testReportUserCanAccessAndDownloadSubmissionReport',
                'case' => 'Test report user can access and download submission report',
                'status' => 'SKIPPED',
                'time' => 0.000000,
                'assertions' => 0
            ),
            array(
                'category' => 'Report Service',
                'subCategory' => 'Access Report Service',
                'component' => 'Bom',
                'signature' => '/app/tests/bom/170_ReportService/AccessReportServiceCest:testReportUserCanAccessAndDownloadPerformanceReport',
                'case' => 'Test report user can access and download performance report',
                'status' => 'PASSED',
                'time' => 0.000038,
                'assertions' => 0
            )
        );

        $data = array(
            'range' => $range,
            'majorDimension' => $dimension,
            'values' => array(
                array(
                    'Component',
                    'Test Scenario',
                    'Category',
                    'Sub category',
                    'Signature',
                    'Run 1',
                    'Run 2',
                ),
                array(
                    "Bom",
                    "Test report user can access and download submission report",
                    "Report Service",
                    "Access Report Service",
                    "/app/tests/bom/170_ReportService/AccessReportServiceCest:testReportUserCanAccessAndDownloadSubmissionReport",
                    "SKIPPED",
                    "SKIPPED",
                ),
                array(
                    "Bom",
                    "Test report user can access and download performance report",
                    "Report Service",
                    "Access Report Service",
                    "/app/tests/bom/170_ReportService/AccessReportServiceCest:testReportUserCanAccessAndDownloadPerformanceReport",
                    "PASSED",
                    "PASSED",
                ),
            )
        );
        $currentValues = array(
            array(
                'Component',
                'Test Scenario',
                'Category',
                'Sub category',
                'Signature',
                'Run 1'
            ),
            array(
                "Bom",
                "Test report user can access and download submission report",
                "Report Service",
                "Access Report Service",
                "/app/tests/bom/170_ReportService/AccessReportServiceCest:testReportUserCanAccessAndDownloadSubmissionReport",
                "SKIPPED"
            ),
            array(
                "Bom",
                "Test report user can access and download performance report",
                "Report Service",
                "Access Report Service",
                "/app/tests/bom/170_ReportService/AccessReportServiceCest:testReportUserCanAccessAndDownloadPerformanceReport",
                "PASSED"
            ),
        );
        $this->assertEquals(
            $data,
            $this->googleSheet->getData($suite, $range, $dimension, $runNumber, $currentValues)
        );
    }

    public function testGetUpperBound()
    {
        $this->assertEquals(
            'I',
            $this->googleSheet->getUpperBound('3')
        );
    }

    public function testGetDataWhenCurrentValueIsEmpty(){
        $range = 'BomA2:B';
        $dimension = 'ROWS';
        $runNumber = 1;
        $suite = array(
            array(
                'category' => 'Report Service',
                'subCategory' => 'Access Report Service',
                'component' => 'Bom',
                'signature' => '/app/tests/bom/170_ReportService/AccessReportServiceCest:testReportUserCanAccessAndDownloadSubmissionReport',
                'case' => 'Test report user can access and download submission report',
                'status' => 'SKIPPED',
                'time' => 0.000000,
                'assertions' => 0
            ),
            array(
                'category' => 'Report Service',
                'subCategory' => 'Access Report Service',
                'component' => 'Bom',
                'signature' => '/app/tests/bom/170_ReportService/AccessReportServiceCest:testReportUserCanAccessAndDownloadPerformanceReport',
                'case' => 'Test report user can access and download performance report',
                'status' => 'PASSED',
                'time' => 0.000038,
                'assertions' => 0
            )
        );

        $data = array(
            'range' => $range,
            'majorDimension' => $dimension,
            'values' => array(
                array(
                    'Component',
                    'Test Scenario',
                    'Category',
                    'Sub category',
                    'Signature',
                    'Run 1',
                ),
                array(
                    "Bom",
                    "Test report user can access and download submission report",
                    "Report Service",
                    "Access Report Service",
                    "/app/tests/bom/170_ReportService/AccessReportServiceCest:testReportUserCanAccessAndDownloadSubmissionReport",
                    "SKIPPED",
                ),
                array(
                    "Bom",
                    "Test report user can access and download performance report",
                    "Report Service",
                    "Access Report Service",
                    "/app/tests/bom/170_ReportService/AccessReportServiceCest:testReportUserCanAccessAndDownloadPerformanceReport",
                    "PASSED",
                ),
            )
        );
        $currentValues = null;
        $this->assertEquals(
            $data,
            $this->googleSheet->getData($suite, $range, $dimension, $runNumber, $currentValues)
        );
    }

    public function testGetDataWhenNoneExistingTestFoundOnSheet()
    {
        $range = 'BomA2:B';
        $dimension = 'ROWS';
        $runNumber = 1;
        $suite = array(
            array(
                'category' => 'Report Service',
                'subCategory' => 'Access Report Service',
                'component' => 'Bom',
                'signature' => '/app/tests/bom/170_ReportService/AccessReportServiceCest:testReportUserCanAccessAndDownloadSubmissionReport',
                'case' => 'Test report user can access and download submission report',
                'status' => 'SKIPPED',
                'time' => 0.000000,
                'assertions' => 0
            ),
            array(
                'category' => 'Report Service',
                'subCategory' => 'Access Report Service',
                'component' => 'Bom',
                'signature' => '/app/tests/bom/170_ReportService/AccessReportServiceCest:testReportUserCanAccessAndDownloadPerformanceReport',
                'case' => 'Test report user can access and download performance report',
                'status' => 'PASSED',
                'time' => 0.000038,
                'assertions' => 0
            )
        );

        $data = array(
            'range' => $range,
            'majorDimension' => $dimension,
            'values' => array(
                array(
                    'Component',
                    'Test Scenario',
                    'Category',
                    'Sub category',
                    'Signature',
                    'Run 1',
                    'Run 2',
                ),
                array(
                    "Bom",
                    "Test report user can access and download submission report",
                    "Report Service",
                    "Access Report Service",
                    "/app/tests/bom/170_ReportService/AccessReportServiceCest:testReportUserCanAccessAndDownloadSubmissionReport",
                    "SKIPPED",
                    "SKIPPED",
                ),
                array(
                    "Bom",
                    "Test report user can access and download performance report",
                    "Report Service",
                    "Access Report Service",
                    "/app/tests/bom/170_ReportService/AccessReportServiceCest:testReportUserCanAccessAndDownloadPerformanceReport",
                    "",
                    "PASSED",
                ),
            )
        );
        $currentValues = array(
            array(
                'Component',
                'Test Scenario',
                'Category',
                'Sub category',
                'Signature',
                'Run 1'
            ),
            array(
                "Bom",
                "Test report user can access and download submission report",
                "Report Service",
                "Access Report Service",
                "/app/tests/bom/170_ReportService/AccessReportServiceCest:testReportUserCanAccessAndDownloadSubmissionReport",
                "SKIPPED"
            ),
            array(
                "Bom",
                "Test report user can access and download performance report",
                "Report Service",
                "Access Report Service",
                "Test no longer found",
                "PASSED"
            ),
        );
        $this->assertEquals(
            $data,
            $this->googleSheet->getData($suite, $range, $dimension, $runNumber, $currentValues)
        );
    }
}