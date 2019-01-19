<?php declare(strict_types = 1);

namespace TestHelpers;

trait SpyTrait
{
    /** @var array $calls */
    private $calls = [];

    public function recordCall()
    {
        $callerInformation = debug_backtrace()[1];

        $this->calls[] = [$callerInformation['function'], $callerInformation['args']];
    }
    
    /**
     * @param string $methodName
     * @return bool
     */
    public function hasMethodBeenCalled(string $methodName): bool
    {
        foreach ($this->calls as [$callMethodName]) {
            if ($callMethodName === $methodName) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $methodName
     * @param array $parameters
     * @return bool
     */
    public function hasMethodBeenCalledWith(string $methodName, array $parameters): bool
    {
        foreach ($this->calls as [$callMethodName, $callParameters]) {
            if ($callMethodName === $methodName && $callParameters === $parameters) {
                return true;
            }
        }

        return false;
    }

    public function reset()
    {
        $this->calls = [];
    }
}
