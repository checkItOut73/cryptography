<?php declare(strict_types = 1);

namespace TestHelpers;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\Comparator\ComparisonFailure;

trait SpyTrait
{
    /** @var string */
    private static $METHOD_HAS_NOT_BEEN_CALLED_MESSAGE =
        'Failed asserting that method "%s" has been called.';

    /** @var string */
    private static $METHOD_HAS_NOT_BEEN_CALLED_WITH_EXPECTED_PARAMETERS_MESSAGE =
        'Failed asserting that method "%s" has been called with %s.';

    /** @var string[] */
    private static $COUNTING_CALLS_KEYS =
        ['first call', 'second call', 'third call', 'forth call', 'fifth call', 'sixth call', 'seventh call'];

    /** @var array $calls */
    private $calls = [];

    public function recordCall()
    {
        $callerInformation = debug_backtrace()[1];

        $this->calls[] = [$callerInformation['function'], $callerInformation['args']];
    }

    /**
     * @param string $expectedMethodName
     * @throws ExpectationFailedException
     */
    public function assertMethodHasBeenCalled(string $expectedMethodName)
    {
        $this->incrementTestCaseAssertionCount();

        if (!$this->hasMethodBeenCalled($expectedMethodName)) {
            $actualCalledMethodNames = $this->getCalledMethodNames();

            throw new ExpectationFailedException(
                sprintf(self::$METHOD_HAS_NOT_BEEN_CALLED_MESSAGE, $expectedMethodName),
                new ComparisonFailure(
                    $expectedMethodName,
                    $actualCalledMethodNames,
                    $expectedMethodName,
                    implode("\n", $actualCalledMethodNames)
                )
            );
        }
    }

    private function incrementTestCaseAssertionCount()
    {
        $testCase = $this->getTestCaseFromDebugBacktrace();

        $testCase->addToAssertionCount(1);
    }

    /**
     * @return TestCase|null
     */
    private function getTestCaseFromDebugBacktrace(): ?TestCase
    {
        foreach (debug_backtrace() as $invocation) {
            if (TestCase::class === $invocation['class']) {
                return $invocation['object'];
            }
        }
    } // @codeCoverageIgnore

    /**
     * @param string $expectedMethodName
     * @return bool
     */
    private function hasMethodBeenCalled(string $expectedMethodName): bool
    {
        return in_array($expectedMethodName, $this->getCalledMethodNames());
    }

    /**
     * @return string[]
     */
    private function getCalledMethodNames(): array
    {
        $calledMethodNames = [];

        foreach ($this->calls as [$calledMethodName]) {
            $calledMethodNames[] = $calledMethodName;
        }

        return $calledMethodNames;
    }

    /**
     * @param string $expectedMethodName
     * @param array $expectedParameters
     * @param bool $strictParameterEquality
     */
    public function assertMethodHasBeenCalledWith(
        string $expectedMethodName,
        array $expectedParameters,
        bool $strictParameterEquality = true
    ) {
        $this->assertMethodHasBeenCalled($expectedMethodName);

        if (!$this->hasMethodBeenCalledWithExpectedParameters(
            $expectedMethodName,
            $expectedParameters,
            $strictParameterEquality
        )) {
            $actualCallsParameters = $this->getMethodCallsParameters($expectedMethodName);

            throw new ExpectationFailedException(
                sprintf(
                    self::$METHOD_HAS_NOT_BEEN_CALLED_WITH_EXPECTED_PARAMETERS_MESSAGE,
                    $expectedMethodName,
                    json_encode($expectedParameters)
                ),
                new ComparisonFailure(
                    $expectedParameters,
                    $actualCallsParameters,
                    json_encode($expectedParameters, JSON_PRETTY_PRINT),
                    $this->getFormattedActualCallsParameters($actualCallsParameters)
                )
            );
        }
    }

    /**
     * @param string $methodName
     * @param array $expectedParameters
     * @param bool $strictParameterEquality
     * @return bool
     */
    private function hasMethodBeenCalledWithExpectedParameters(
        string $methodName,
        array $expectedParameters,
        bool $strictParameterEquality
    ): bool {
        return in_array($expectedParameters, $this->getMethodCallsParameters($methodName), $strictParameterEquality);
    }
    
    /**
     * @param string $methodName
     * @return array
     */
    private function getMethodCallsParameters(string $methodName): array
    {
        $methodCallsParameters = [];

        foreach ($this->calls as [$callMethodName, $callParameters]) {
            if ($callMethodName === $methodName) {
                $methodCallsParameters[] = $callParameters;
            }
        }

        return $methodCallsParameters;
    }

    /**
     * @param array $actualCallsParameters
     * @return string
     */
    private function getFormattedActualCallsParameters(array $actualCallsParameters): string
    {
        if (sizeof($actualCallsParameters) > 1) {
            $formattedCalls = [];

            foreach ($actualCallsParameters as $index => $callParameters) {
                $formattedCalls[] = (
                    $this->getComparisonHeadline(self::$COUNTING_CALLS_KEYS[$index] . ':') .
                    json_encode($callParameters, JSON_PRETTY_PRINT)
                );
            }

            $formatted = implode("\n\n\n", $formattedCalls);
        } else {
            $formatted = json_encode($actualCallsParameters[0], JSON_PRETTY_PRINT);
        }

        return $formatted;
    }

    /**
     * @param string $headline
     * @return string
     */
    private function getComparisonHeadline(string $headline): string
    {
        return (
            $headline . "\n" .
            str_repeat('-', strlen($headline)) . "\n"
        );
    }

    public function reset()
    {
        $this->calls = [];
    }
}
