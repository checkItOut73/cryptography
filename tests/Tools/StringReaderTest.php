<?php declare(strict_types = 1);

namespace Tools;

use PHPUnit\Framework\TestCase;
use Tools\Exceptions\EmptyStringParameterException;
use Tools\Exceptions\StringCharacterIndexOutOfBoundsException;
use Tools\Exceptions\InvalidCharacterParameterException;
use Tools\Exceptions\OperationOnEmptyStringException;

/**
 * @covers \Tools\StringReader
 * @uses \Tools\Exceptions\InvalidCharacterParameterException
 * @uses \Tools\Exceptions\OperationOnEmptyStringException
 * @uses \Tools\StringCharacterPointer
 */
class StringReaderTest extends TestCase
{
    /** @var StringReader $stringReader */
    private $stringReader;

    public function setUp()
    {
        $this->stringReader = new StringReader();
    }

    public function testStringReaderExtendsStringCharacterPointer()
    {
        $this->assertTrue(is_subclass_of($this->stringReader, StringCharacterPointer::class));
    }

    /**
     * @return array
     */
    public function containedCharactersDataProvider(): array
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
    public function testIsCharacterContainedReturnsTrueForContainedCharacters(string $containedCharacter)
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
    public function invalidCharacterDataProvider(): array
    {
        return [[''], ['AB']];
    }

    /**
     * @dataProvider invalidCharacterDataProvider
     * @param string $invalidCharacter
     * @expectedException \Tools\Exceptions\InvalidCharacterParameterException
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws OperationOnEmptyStringException
     */
    public function testIsCharacterContainedThrowsIfTheGivenCharacterIsInvalid(string $invalidCharacter)
    {
        $this->stringReader->setString('ABC');

        $this->expectExceptionMessage(
            'The given parameter is not a valid character: ' . $invalidCharacter . '.'
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
    public function testReadPointedCharacterAppendsThePointedCharacterToTheReadString()
    {
        $this->stringReader->setString('ABC', 1);
        $this->stringReader->readPointedCharacter();

        $this->assertEquals('B', $this->stringReader->getReadString());
    }

    /**
     * @expectedException \Tools\Exceptions\OperationOnEmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     */
    public function testReadPointedCharacterThrowsIfTheStringIsEmpty()
    {
        $this->stringReader->readPointedCharacter();
    }

    /**
     * @throws EmptyStringParameterException
     * @throws OperationOnEmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testFlushReadStringEmptiesTheReadString()
    {
        $this->stringReader->setString('ABC');
        $this->stringReader->readPointedCharacter();

        $this->stringReader->flushReadString();

        $this->assertEquals('', $this->stringReader->getReadString());
    }

    /**
     * @throws EmptyStringParameterException
     * @throws OperationOnEmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testGetFlushedReadStringEmptiesAndReturnsTheReadString()
    {
        $this->stringReader->setString('ABC', 1);
        $this->stringReader->readPointedCharacter();

        $this->assertEquals('B', $this->stringReader->getFlushedReadString());
        $this->assertEquals('', $this->stringReader->getReadString());
    }
}
