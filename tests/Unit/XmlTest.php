<?php
/**
 * Created by PhpStorm.
 * User: devert
 * Date: 2/17/19
 * Time: 8:03 PM
 */

namespace Devert\Unit;

use Devert\Util\TestFormatter;

class XmlTest extends \PHPUnit\Framework\TestCase
{
    protected $path;
    /**
     * @var TestFormatter
     */
    protected $xml;

    public function setUp()
    {
        $this->path = '/app/tests/api_vev/110_RejectionReason/VevRejectionReasonCest.php';
        $this->xml = new TestFormatter();
    }

    public function testCorrectSubCategoryIsReturned() {

        $this->assertEquals('Vev Rejection Reason', $this->xml->subCategory($this->path));
    }

    public function testCorrectCategoryIsReturned() {
        $this->assertEquals('Rejection Reason', $this->xml->category($this->path));
    }

    public function testCamelCaseIsConvertedToSentence() {
        $camelCase = 'VevRejectionReasonTestCest';
        $this->assertEquals('Vev Rejection Reason Test Cest', $this->xml->convertCamelCaseToSentence($camelCase));
    }
}
