<?php declare(strict_types = 1);

namespace Tools\Exceptions;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Tools\Exceptions\StringCharacterIndexOutOfBoundsException
 */
class StringCharacterIndexOutOfBoundsExceptionTest extends TestCase
{
    /** @var StringCharacterIndexOutOfBoundsException $exception */
    private $exception;

    public function setUp()
    {
        $this->exception = new StringCharacterIndexOutOfBoundsException(9, 10);
    }

    public function testTheExceptionHasTheCorrectMessage()
    {
        $this->assertEquals(
            'The given character index is outside the string bounds [0, 9]: 10.',
            $this->exception->getMessage()
        );
    }
}
