<?php declare(strict_types = 1);

namespace TestHelpers;

class TestSpy
{
    use SpyTrait;

    /**
     * @return string
     */
    public function getData(): string
    {
        return 'data';
    }

    public function doSomething()
    {
        $this->recordCall();
    }

    /**
     * @param array $options
     */
    public function doSomethingSpecific(array $options)
    {
        $this->recordCall();
    }

    /**
     * @param array $options
     */
    public function doSomethingElse(array $options)
    {
        $this->recordCall();
    }
}
