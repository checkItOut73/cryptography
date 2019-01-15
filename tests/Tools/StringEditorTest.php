<?php
namespace Tools;

use PHPUnit\Framework\TestCase;
use Tools\Exceptions\EmptyStringException;
use Tools\Exceptions\StringCharacterIndexOutOfBoundsException;
use Tools\Exceptions\InvalidCharacterException;
use Tools\Mocks\StringBufferSpy;

class StringEditorTest extends TestCase
{
    /** @var StringBufferSpy $readStringBufferSpy */
    private $readStringBufferSpy;

    /** @var StringEditor $stringEditor */
    private $stringEditor;

    public function setUp()
    {
        $this->readStringBufferSpy = new StringBufferSpy();
        $this->stringEditor = new StringEditor($this->readStringBufferSpy);
    }

    public function testStringEditorExtendsStringReader()
    {
        $this->assertTrue(is_subclass_of($this->stringEditor, StringReader::class));
    }

    /**
     * @throws EmptyStringException
     * @throws InvalidCharacterException
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testSetPointedCharacterSetsTheCharacterCorrectly()
    {
        $this->stringEditor->setString('ABC', 1);
        $this->stringEditor->setPointedCharacter('N');

        $this->assertEquals('ANC', $this->stringEditor->getString());
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
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws EmptyStringException
     * @dataProvider invalidCharacterDataProvider
     * @param string $invalidCharacter
     */
    public function testSetPointedCharacterThrowsIfTheGivenCharacterIsInvalid($invalidCharacter)
    {
        $this->stringEditor->setString('ABC');

        $this->expectExceptionMessage(
            'The given argument is not a valid character: ' . $invalidCharacter. '.'
        );

        $this->stringEditor->setPointedCharacter($invalidCharacter);
    }

    /**
     * @expectedException \Tools\Exceptions\EmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     * @throws InvalidCharacterException
     */
    public function testSetPointedCharacterThrowsIfTheStringIsEmpty()
    {
        $this->stringEditor->setPointedCharacter('A');
    }

    /**
     * @return array
     */
    public function removePointedCharacterDataProvider()
    {
        return [
            [0, 'BC', 0],
            [1, 'AC', 1],
            [2, 'AB', 1]
        ];
    }

    /**
     * @dataProvider removePointedCharacterDataProvider
     * @param int $pointedCharacterIndex
     * @param string $expectedEditedString
     * @param int $expectedPointedCharacterIndexAfterEditing
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testRemovePointedCharacterRemovesTheCharacterCorrectly(
        $pointedCharacterIndex,
        $expectedEditedString,
        $expectedPointedCharacterIndexAfterEditing
    ) {
        $this->stringEditor->setString('ABC', $pointedCharacterIndex);
        $this->stringEditor->removePointedCharacter();

        $this->assertEquals($expectedEditedString, $this->stringEditor->getString());
        $this->assertEquals(
            $expectedPointedCharacterIndexAfterEditing,
            $this->stringEditor->getPointedCharacterIndex()
        );
    }

    /**
     * @expectedException \Tools\Exceptions\EmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testRemovePointedCharacterThrowsIfTheStringIsEmpty()
    {
        $this->stringEditor->removePointedCharacter();
    }
}
