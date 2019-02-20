<?php declare(strict_types = 1);

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
        $this->testSpy->doSomethingSpecific(['ABC']);

        $this->assertTrue($this->testSpy->hasMethodBeenCalledWith('doSomethingSpecific', [['ABC']]));
    }

    public function testHasMethodBeenCalledWithReturnsFalseIfAnotherMethodHasBeenCalledWithTheGivenParameters()
    {
        $this->testSpy->doSomethingSpecific(['ABC']);

        $this->assertFalse($this->testSpy->hasMethodBeenCalledWith('thatHasNotBeenDone', [['ABC']]));
    }

    public function testHasMethodBeenCalledWithReturnsFalseIfTheMethodHasBeenCalledWithOtherButEqualObjects()
    {
        $testObject = new TestClass(['ABC']);
        $equalTestObject = new TestClass(['ABC']);

        $this->testSpy->doSomethingSpecific(['testObject' => $testObject]);

        $this->assertFalse($this->testSpy->hasMethodBeenCalledWith(
            'doSomethingSpecific',
            [['testObject' => $equalTestObject]]
        ));
    }

    public function testHasMethodBeenCalledWithReturnsTrueIfCalledWithOtherEqualObjectsWithoutStrictParameterEquality()
    {
        $testObject = new TestClass(['ABC']);
        $equalTestObject = new TestClass(['ABC']);

        $this->testSpy->doSomethingSpecific(['testObject' => $testObject]);

        $this->assertTrue($this->testSpy->hasMethodBeenCalledWith(
            'doSomethingSpecific',
            [['testObject' => $equalTestObject]],
            false
        ));
    }

    public function testHasMethodBeenCalledWithReturnsFalseIfCalledWithDifferingObjectsWithoutStrictParameterEquality()
    {
        $testObject = new TestClass(['ABC']);
        $differingTestObject = new TestClass(['XYZ']);

        $this->testSpy->doSomethingSpecific(['testObject' => $testObject]);

        $this->assertFalse($this->testSpy->hasMethodBeenCalledWith(
            'doSomethingSpecific',
            ['testObject' => $differingTestObject],
            false
        ));
    }

    public function testResetClearsTheCallHistory()
    {
        $this->testSpy->doSomethingSpecific(['ABC']);

        $this->testSpy->reset();

        $this->assertFalse($this->testSpy->hasMethodBeenCalled('doSomethingSpecific'));
        $this->assertFalse($this->testSpy->hasMethodBeenCalledWith('doSomethingSpecific', [['ABC']]));
    }
}
