<?php declare(strict_types = 1);

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
    public function appendString(string $string)
    {
        $this->recordCall();
    }
}
