<?php

namespace Devert\Util;

class CollectionXml extends \PHPUnit\Framework\TestCase
{

    /** @test array */
    protected $testArray = [];

    /** @test string */
    protected $testXml;

    public function setUp() : void
    {
        $this->testArray = [
            'carrier' => 'fedex',
            'id' => 123,
            'tracking_number' => '9205590164917312751089',
        ];
        $this->testXml = '<?xml version="1.0"?><root><carrier>fedex</carrier><id>123</id><tracking_number>9205590164917312751089</tracking_number></root>';
    }

    /** @test */
    public function testConvertXmlToArray()
    {
        $this->assertEquals(XmlToArray::convert($this->testXml), $this->testArray);
    }
}
