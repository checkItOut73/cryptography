<?php declare(strict_types = 1);

namespace Tools\Exceptions;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Tools\Exceptions\StringCharacterNotContainedException
 */
class StringCharacterNotContainedExceptionTest extends TestCase
{
    /** @var StringCharacterNotContainedException $exception */
    private $exception;

    public function setUp()
    {
        $this->exception = new StringCharacterNotContainedException('A');
    }

    public function testTheExceptionHasTheCorrectMessage()
    {
        $this->assertEquals(
            'The character to go to is not contained in the string: A.',
            $this->exception->getMessage()
        );
    }
}
