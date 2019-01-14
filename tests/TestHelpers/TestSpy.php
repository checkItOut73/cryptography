<?php
namespace TestHelpers;

class TestSpy
{
    use SpyTrait;

    /**
     * @return string
     */
    public function getData()
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
