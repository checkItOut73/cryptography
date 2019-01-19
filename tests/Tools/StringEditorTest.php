<?php declare(strict_types = 1);

namespace Tools;

use PHPUnit\Framework\TestCase;
use Tools\Exceptions\EmptyStringParameterException;
use Tools\Exceptions\StringCharacterIndexOutOfBoundsException;
use Tools\Exceptions\InvalidCharacterParameterException;
use Tools\Exceptions\OperationOnEmptyStringException;
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
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws InvalidCharacterParameterException
     * @throws OperationOnEmptyStringException
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
    public function invalidCharacterDataProvider(): array
    {
        return [[''], ['AB']];
    }

    /**
     * @expectedException \Tools\Exceptions\InvalidCharacterParameterException
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws OperationOnEmptyStringException
     * @dataProvider invalidCharacterDataProvider
     * @param string $invalidCharacter
     */
    public function testSetPointedCharacterThrowsIfTheGivenCharacterIsInvalid(string $invalidCharacter)
    {
        $this->stringEditor->setString('ABC');

        $this->expectExceptionMessage(
            'The given parameter is not a valid character: ' . $invalidCharacter . '.'
        );

        $this->stringEditor->setPointedCharacter($invalidCharacter);
    }

    /**
     * @expectedException \Tools\Exceptions\OperationOnEmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     * @throws InvalidCharacterParameterException
     */
    public function testSetPointedCharacterThrowsIfTheStringIsEmpty()
    {
        $this->stringEditor->setPointedCharacter('A');
    }

    /**
     * @return array
     */
    public function removePointedCharacterDataProvider(): array
    {
        return [
            ['ABC', 0, 'BC', 0],
            ['ABC', 1, 'AC', 1],
            ['ABC', 2, 'AB', 0],
            ['A',   0, '',   null]
        ];
    }

    /**
     * @dataProvider removePointedCharacterDataProvider
     * @param string $inputString
     * @param int $pointedCharacterIndex
     * @param string $expectedEditedString
     * @param int $expectedPointedCharacterIndexAfterEditing
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws OperationOnEmptyStringException
     */
    public function testRemovePointedCharacterRemovesTheCharacterCorrectly(
        string $inputString,
        int $pointedCharacterIndex,
        string $expectedEditedString,
        ?int $expectedPointedCharacterIndexAfterEditing
    ) {
        $this->stringEditor->setString($inputString, $pointedCharacterIndex);

        $this->stringEditor->removePointedCharacter();

        $this->assertEquals($expectedEditedString, $this->stringEditor->getString());

        if (!is_null($expectedPointedCharacterIndexAfterEditing)) {
            $this->assertEquals(
                $expectedPointedCharacterIndexAfterEditing,
                $this->stringEditor->getPointedCharacterIndex()
            );
        }
    }

    /**
     * @expectedException \Tools\Exceptions\OperationOnEmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     */
    public function testRemovePointedCharacterThrowsIfTheStringIsEmpty()
    {
        $this->stringEditor->removePointedCharacter();
    }

    /**
     * @return array
     */
    public function removeFirstCharacterDataProvider(): array
    {
        return [
            ['ABC', 0, 'BC', 0],
            ['ABC', 2, 'BC', 1],
            ['A',   0, '',   null]
        ];
    }

    /**
     * @dataProvider removeFirstCharacterDataProvider
     * @param string $inputString
     * @param int $pointedCharacterIndex
     * @param string $expectedEditedString
     * @param int $expectedPointedCharacterIndexAfterEditing
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws OperationOnEmptyStringException
     */
    public function testRemoveFirstCharacterRemovesTheFirstCharacterOfTheString(
        string $inputString,
        int $pointedCharacterIndex,
        string $expectedEditedString,
        ?int $expectedPointedCharacterIndexAfterEditing
    ) {
        $this->stringEditor->setString($inputString, $pointedCharacterIndex);

        $this->stringEditor->removeFirstCharacter();

        $this->assertEquals($expectedEditedString, $this->stringEditor->getString());

        if (!is_null($expectedPointedCharacterIndexAfterEditing)) {
            $this->assertEquals(
                $expectedPointedCharacterIndexAfterEditing,
                $this->stringEditor->getPointedCharacterIndex()
            );
        }
    }

    /**
     * @expectedException \Tools\Exceptions\OperationOnEmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     */
    public function testRemoveFirstCharacterThrowsIfTheStringIsEmpty()
    {
        $this->stringEditor->removeFirstCharacter();
    }

    /**
     * @return array
     */
    public function cutPointedCharacterDataProvider(): array
    {
        return [
            ['ABC', 0, 'BC', 0,    'A'],
            ['ABC', 1, 'AC', 1,    'B'],
            ['ABC', 2, 'AB', 0,    'C'],
            ['A',   0, '',   null, 'A']
        ];
    }

    /**
     * @dataProvider cutPointedCharacterDataProvider
     * @param string $inputString
     * @param int $pointedCharacterIndex
     * @param string $expectedEditedString
     * @param int $expectedPointedCharacterIndexAfterEditing
     * @param string $expectedReadCharacter
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws OperationOnEmptyStringException
     */
    public function testCutPointedCharacterRemovesAndReadsTheCharacterCorrectly(
        string $inputString,
        int $pointedCharacterIndex,
        string $expectedEditedString,
        ?int $expectedPointedCharacterIndexAfterEditing,
        string $expectedReadCharacter
    ) {
        $this->stringEditor->setString($inputString, $pointedCharacterIndex);

        $this->stringEditor->cutPointedCharacter();

        $this->assertEquals($expectedEditedString, $this->stringEditor->getString());

        if (!is_null($expectedPointedCharacterIndexAfterEditing)) {
            $this->assertEquals(
                $expectedPointedCharacterIndexAfterEditing,
                $this->stringEditor->getPointedCharacterIndex()
            );
        }

        $this->assertTrue(
            $this->readStringBufferSpy->hasMethodBeenCalledWith('appendString', [$expectedReadCharacter])
        );
    }

    /**
     * @expectedException \Tools\Exceptions\OperationOnEmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     */
    public function testCutPointedCharacterThrowsIfTheStringIsEmpty()
    {
        $this->stringEditor->cutPointedCharacter();
    }
}
