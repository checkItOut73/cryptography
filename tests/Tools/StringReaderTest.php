<?php
namespace Tools;

use PHPUnit\Framework\TestCase;
use Tools\Exceptions\EmptyStringParameterException;
use Tools\Exceptions\StringCharacterIndexOutOfBoundsException;
use Tools\Exceptions\InvalidCharacterParameterException;
use Tools\Exceptions\OperationOnEmptyStringException;
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
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws InvalidCharacterParameterException
     * @throws OperationOnEmptyStringException
     */
    public function testIsCharacterContainedReturnsTrueForCharactersThatAreContainedInTheString($containedCharacter)
    {
        $this->stringReader->setString('ABC');

        $this->assertTrue($this->stringReader->isCharacterContained($containedCharacter));
    }

    /**
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws InvalidCharacterParameterException
     * @throws OperationOnEmptyStringException
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
     * @expectedException \Tools\Exceptions\InvalidCharacterParameterException
     * @dataProvider invalidCharacterDataProvider
     * @param string $invalidCharacter
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws OperationOnEmptyStringException
     */
    public function testIsCharacterContainedThrowsIfTheGivenCharacterIsInvalid($invalidCharacter)
    {
        $this->stringReader->setString('ABC');

        $this->expectExceptionMessage(
            'The given parameter is not a valid character: ' . $invalidCharacter. '.'
        );

        $this->stringReader->isCharacterContained($invalidCharacter);
    }

    /**
     * @expectedException \Tools\Exceptions\OperationOnEmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     * @throws InvalidCharacterParameterException
     */
    public function testIsCharacterContainedThrowsIfTheStringIsEmpty()
    {
        $this->stringReader->isCharacterContained('A');
    }

    /**
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws OperationOnEmptyStringException
     */
    public function testReadPointedCharacterAppendsThePointedCharacterToTheStringBuffer()
    {
        $this->stringReader->setString('ABC', 1);
        $this->stringReader->readPointedCharacter();

        $this->assertTrue($this->readStringBufferSpy->hasMethodBeenCalledWith('appendString', ['B']));
    }

    /**
     * @expectedException \Tools\Exceptions\OperationOnEmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     */
    public function testReadPointedCharacterThrowsIfTheStringIsEmpty()
    {
        $this->stringReader->readPointedCharacter();
    }
}
