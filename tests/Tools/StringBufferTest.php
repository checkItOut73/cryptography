<?php
namespace Tools;

use PHPUnit\Framework\TestCase;

class StringBufferTest extends TestCase
{
    /** @var StringBuffer $stringBuffer */
    private $stringBuffer;

    public function setUp()
    {
        $this->stringBuffer = new StringBuffer('ABC');
    }

    public function testTheStringGivenToTheConstructorIsSet()
    {
        $this->assertEquals('ABC', $this->stringBuffer->getString());
    }

    public function testAnEmptyStringIsSetIfNoStringIsGivenToTheConstructor()
    {
        $this->stringBuffer = new StringBuffer();

        $this->assertEquals('', $this->stringBuffer->getString());
    }

    public function testAppendStringAddsTheGivenStringToTheEnd()
    {
        $this->stringBuffer->appendString('DEF');

        $this->assertEquals('ABCDEF', $this->stringBuffer->getString());
    }

    public function testFlushSetsTheStringToAnEmptyString()
    {
        $this->stringBuffer->flush();

        $this->assertEquals('', $this->stringBuffer->getString());
    }
}
