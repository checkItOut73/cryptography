<?php declare(strict_types = 1);

namespace Tools\Exceptions;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Tools\Exceptions\EmptyStringParameterException
 */
class EmptyStringParameterExceptionTest extends TestCase
{
    /** @var EmptyStringParameterException $exception */
    private $exception;

    public function setUp()
    {
        $this->exception = new EmptyStringParameterException();
    }

    public function testTheExceptionHasTheCorrectMessage()
    {
        $this->assertEquals(
            'The string parameter must not be empty.',
            $this->exception->getMessage()
        );
    }
}
