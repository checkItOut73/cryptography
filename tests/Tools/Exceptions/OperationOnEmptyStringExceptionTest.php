<?php declare(strict_types = 1);

namespace Tools\Exceptions;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Tools\Exceptions\OperationOnEmptyStringException
 */
class OperationOnEmptyStringExceptionTest extends TestCase
{
    /** @var OperationOnEmptyStringException $exception */
    private $exception;

    public function setUp()
    {
        $this->exception = new OperationOnEmptyStringException();
    }

    public function testTheExceptionHasTheCorrectMessage()
    {
        $this->assertEquals(
            'The requested operation cannot be processed because the string is empty.',
            $this->exception->getMessage()
        );
    }
}
