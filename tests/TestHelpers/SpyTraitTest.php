<?php declare(strict_types = 1);

namespace TestHelpers;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\Comparator\ComparisonFailure;

/**
 * @covers \TestHelpers\SpyTrait
 */
class SpyTraitTest extends TestCase
{
    /** @var TestSpy $testSpy */
    private $testSpy;

    public function setUp()
    {
        $this->testSpy = new TestSpy();
    }

    public function testAssertMethodHasBeenCalledDoesNotThrowIfTheMethodHasBeenCalled()
    {
        $this->testSpy->doSomething();

        $this->testSpy->assertMethodHasBeenCalled('doSomething');
        $this->assertSame(1, $this->getNumAssertions());
    }

    public function testAssertMethodHasBeenCalledThrowsIfTheMethodHasNotBeenCalled()
    {
        $this->testSpy->doSomethingElse([]);
        $this->testSpy->doSomethingSpecific([]);

        try {
            $this->testSpy->assertMethodHasBeenCalled('doSomething');
        } catch (ExpectationFailedException $exception) {
            $this->assertSame('Failed asserting that method "doSomething" has been called.', $exception->getMessage());
            $this->assertEquals(
                new ComparisonFailure(
                    'doSomething',
                    ['doSomethingElse', 'doSomethingSpecific'],
                    'doSomething',
                    'doSomethingElse' . "\n" . 'doSomethingSpecific'
                ),
                $exception->getComparisonFailure()
            );
        }
    }

    public function testAssertMethodHasBeenCalledWithDoesNotThrowIfTheMethodHasBeenCalledWithTheGivenParameters()
    {
        $this->testSpy->doSomethingSpecific(['ZYX']);
        $this->testSpy->doSomethingSpecific(['ABC']);

        $this->testSpy->assertMethodHasBeenCalledWith('doSomethingSpecific', [['ZYX']]);
        $this->testSpy->assertMethodHasBeenCalledWith('doSomethingSpecific', [['ABC']]);
        $this->assertSame(2, $this->getNumAssertions());
    }

    public function testAssertMethodHasBeenCalledWithThrowsIfAnotherMethodHasBeenCalledWithTheGivenParameters()
    {
        $this->testSpy->doSomethingSpecific(['ABC']);

        try {
            $this->testSpy->assertMethodHasBeenCalledWith('thisHasNotBeenDone', [['ABC']]);
        } catch (ExpectationFailedException $exception) {
            $this->assertSame(
                'Failed asserting that method "thisHasNotBeenDone" has been called.',
                $exception->getMessage()
            );
            $this->assertEquals(
                new ComparisonFailure(
                    'thisHasNotBeenDone',
                    ['doSomethingSpecific'],
                    'thisHasNotBeenDone',
                    'doSomethingSpecific'
                ),
                $exception->getComparisonFailure()
            );
        }
    }

    public function testAssertMethodHasBeenCalledWithThrowsIfTheMethodHasBeenCalledWithOtherButEqualObjects()
    {
        $testObject = new TestClass(['ABC']);
        $equalTestObject = new TestClass(['ABC']);

        $this->testSpy->doSomethingSpecific(['testObject' => $testObject]);

        try {
            $this->testSpy->assertMethodHasBeenCalledWith(
                'doSomethingSpecific',
                [['testObject' => $equalTestObject]]
            );
        } catch (ExpectationFailedException $exception) {
            $expected = [['testObject' => $equalTestObject]];
            $actual = [[['testObject' => $testObject]]];

            $this->assertSame(
                'Failed asserting that method "doSomethingSpecific" has been called with [{"testObject":{}}].',
                $exception->getMessage()
            );
            $this->assertEquals(
                new ComparisonFailure(
                    $expected,
                    $actual,
                    json_encode($expected, JSON_PRETTY_PRINT),
                    json_encode($actual[0], JSON_PRETTY_PRINT)
                ),
                $exception->getComparisonFailure()
            );
        }
    }

    public function testAssertMethodHasBeenCalledWithDoesNotThrowIfCalledWithOtherEqualObjectsWithoutStrictEquality()
    {
        $testObject = new TestClass(['ABC']);
        $equalTestObject = new TestClass(['ABC']);

        $this->testSpy->doSomethingSpecific(['testObject' => $testObject]);

        $this->testSpy->assertMethodHasBeenCalledWith(
            'doSomethingSpecific',
            [['testObject' => $equalTestObject]],
            false
        );
        $this->assertSame(1, $this->getNumAssertions());
    }

    public function testAssertMethodHasBeenCalledWithThrowsIfCalledWithDifferingObjectsWithoutStrictParameterEquality()
    {
        $testObject = new TestClass(['ABC']);
        $differingTestObject = new TestClass(['XYZ']);

        $this->testSpy->doSomethingSpecific(['123']);
        $this->testSpy->doSomethingSpecific(['testObject' => $testObject]);

        try {
            $this->testSpy->assertMethodHasBeenCalledWith(
                'doSomethingSpecific',
                [['testObject' => $differingTestObject]],
                false
            );
        } catch (ExpectationFailedException $exception) {
            $expected = [['testObject' => $differingTestObject]];
            $actual = [[['123']], [['testObject' => $testObject]]];

            $this->assertSame(
                'Failed asserting that method "doSomethingSpecific" has been called with [{"testObject":{}}].',
                $exception->getMessage()
            );
            $this->assertEquals(
                new ComparisonFailure(
                    $expected,
                    $actual,
                    json_encode($expected, JSON_PRETTY_PRINT),
                    implode(
                        "\n",
                        [
                            'first call:',
                            '-----------',
                            json_encode($actual[0], JSON_PRETTY_PRINT),
                            "\n",
                            'second call:',
                            '------------',
                            json_encode($actual[1], JSON_PRETTY_PRINT)
                        ]
                    )
                ),
                $exception->getComparisonFailure()
            );
        }
    }

    /**
     * @expectedException \PHPUnit\Framework\ExpectationFailedException
     */
    public function testResetClearsTheCallHistoryForAssertMethodHasBeenCalled()
    {
        $this->testSpy->doSomethingSpecific(['ABC']);

        $this->testSpy->reset();

        $this->testSpy->assertMethodHasBeenCalled('doSomethingSpecific');
    }

    /**
     * @expectedException \PHPUnit\Framework\ExpectationFailedException
     */
    public function testResetClearsTheCallHistoryForAssertMethodHasBeenCalledWith()
    {
        $this->testSpy->doSomethingSpecific(['ABC']);

        $this->testSpy->reset();

        $this->testSpy->assertMethodHasBeenCalledWith('doSomethingSpecific', [['ABC']]);
    }
}
