<?php
namespace TestHelpers;

use PHPUnit\Framework\TestCase;

class SpyTraitTest extends TestCase
{
    /** @var TestSpy $testSpy */
    private $testSpy;

    public function setUp()
    {
        $this->testSpy = new TestSpy();
    }

    public function testHasMethodBeenCalledReturnsTrueIfTheMethodHasBeenCalled()
    {
        $this->testSpy->doSomething();

        $this->assertTrue($this->testSpy->hasMethodBeenCalled('doSomething'));
    }

    public function testHasMethodBeenCalledReturnsFalseIfTheMethodHasNotBeenCalled()
    {
        $this->assertFalse($this->testSpy->hasMethodBeenCalled('doSomething'));
    }

    public function testHasMethodBeenCalledWithReturnsTrueIfTheMethodHasBeenCalledWithTheGivenParameters()
    {
        $this->testSpy->doSomethingSpecific(
            'someParameter',
            12345,
            ['ABC']
        );

        $this->assertTrue(
            $this->testSpy->hasMethodBeenCalledWith(
                'doSomethingSpecific',
                [
                    'someParameter',
                    12345,
                    ['ABC']
                ]
            )
        );
    }

    public function testHasMethodBeenCalledWithReturnsFalseIfTheMethodHasBeenCalledWithOtherParameters()
    {
        $this->testSpy->doSomethingSpecific(
            'someParameter',
            12345,
            ['ABC']
        );

        $this->assertFalse(
            $this->testSpy->hasMethodBeenCalledWith(
                'doSomethingSpecific',
                [
                    'someParameter',
                    12345,
                    ['ABCX']
                ]
            )
        );
    }

    public function testResetClearsTheCallHistory()
    {
        $this->testSpy->doSomethingSpecific(
            'someParameter',
            12345,
            ['ABC']
        );

        $this->testSpy->reset();

        $this->assertFalse($this->testSpy->hasMethodBeenCalled('doSomethingSpecific'));
        $this->assertFalse(
            $this->testSpy->hasMethodBeenCalledWith(
                'doSomethingSpecific',
                [
                    'someParameter',
                    12345,
                    ['ABC']
                ]
            )
        );
    }
}
