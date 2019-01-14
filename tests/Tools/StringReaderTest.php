<?php
namespace Tools;

use PHPUnit\Framework\TestCase;
use Tools\Exceptions\EmptyStringException;
use Tools\Exceptions\StringCharacterIndexOutOfBoundsException;
use Tools\Exceptions\InvalidCharacterException;
use Tools\Mocks\StringBufferSpy;

class StringReaderTest extends TestCase
{
    /** @var StringBufferSpy $readStringBufferSpy */
    private $readStringBufferSpy;

    /** @var StringReader $stringReader */
    private $stringReader;

    public function setUp()
    {
        $this->readStringBufferSpy = new StringBufferSpy();
        $this->stringReader = new StringReader($this->readStringBufferSpy);
    }

    public function testStringReaderExtendsStringCharacterPointer()
    {
        $this->assertTrue(is_subclass_of($this->stringReader, StringCharacterPointer::class));
    }

    /**
     * @return array
     */
    public function containedCharactersDataProvider()
    {
        return [['A'], ['B'], ['C']];
    }

    /**
     * @dataProvider containedCharactersDataProvider
     * @param string $containedCharacter
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws InvalidCharacterException
     */
    public function testIsCharacterContainedReturnsTrueForCharactersThatAreContainedInTheString($containedCharacter)
    {
        $this->stringReader->setString('ABC');

        $this->assertTrue($this->stringReader->isCharacterContained($containedCharacter));
    }

    /**
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws InvalidCharacterException
     */
    public function testIsCharacterContainedReturnsFalseForCharactersThatAreNotContainedInTheString()
    {
        $this->stringReader->setString('ABC');

        $this->assertFalse($this->stringReader->isCharacterContained('a'));
    }

    /**
     * @return array
     */
    public function invalidCharacterDataProvider()
    {
        return [[''], ['AB']];
    }

    /**
     * @expectedException \Tools\Exceptions\InvalidCharacterException
     * @dataProvider invalidCharacterDataProvider
     * @param string $invalidCharacter
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testIsCharacterContainedThrowsIfTheGivenCharacterIsInvalid($invalidCharacter)
    {
        $this->stringReader->setString('ABC');

        $this->expectExceptionMessage(
            'The given argument is not a valid character: ' . $invalidCharacter. '.'
        );

        $this->stringReader->isCharacterContained($invalidCharacter);
    }

    /**
     * @expectedException \Tools\Exceptions\EmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     * @throws InvalidCharacterException
     */
    public function testIsCharacterContainedThrowsIfTheStringIsEmpty()
    {
        $this->stringReader->isCharacterContained('A');
    }

    /**
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testReadPointedCharacterAppendsThePointedCharacterToTheStringBuffer()
    {
        $this->stringReader->setString('ABC', 1);
        $this->stringReader->readPointedCharacter();

        $this->assertTrue($this->readStringBufferSpy->hasMethodBeenCalledWith('appendString', ['B']));
    }
}
