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
     * @param $parameter1
     * @param $parameter2
     * @param $parameter3
     */
    public function doSomethingSpecific($parameter1, $parameter2, $parameter3)
    {
        $this->recordCall();
    }
}
