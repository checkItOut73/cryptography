<?php declare(strict_types = 1);

namespace Tools\Exceptions;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Tools\Exceptions\InvalidCharacterParameterException
 */
class InvalidCharacterParameterExceptionTest extends TestCase
{
    /** @var InvalidCharacterParameterException $exception */
    private $exception;

    public function setUp()
    {
        $this->exception = new InvalidCharacterParameterException('î');
    }

    public function testTheExceptionHasTheCorrectMessage()
    {
        $this->assertEquals(
            'The given parameter is not a valid character: î.',
            $this->exception->getMessage()
        );
    }
}
