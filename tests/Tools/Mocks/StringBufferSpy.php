<?php
namespace Tools\Mocks;

use TestHelpers\SpyTrait;
use Tools\StringBuffer;

class StringBufferSpy extends StringBuffer
{
    use SpyTrait;

    public function __construct()
    {
    }

    /**
     * @inheritdoc
     */
    public function appendString($string)
    {
        $this->recordCall();
    }
}
