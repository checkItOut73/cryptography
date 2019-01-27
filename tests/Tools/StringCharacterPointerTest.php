<?php declare(strict_types = 1);

namespace Tools;

use PHPUnit\Framework\TestCase;
use Tools\Exceptions\EmptyStringParameterException;
use Tools\Exceptions\StringCharacterNotContainedException;
use Tools\Exceptions\OperationOnEmptyStringException;
use Tools\Exceptions\StringCharacterIndexOutOfBoundsException;
use Tools\Exceptions\InvalidCharacterParameterException;

class StringCharacterPointerTest extends TestCase
{
    /** @var StringCharacterPointer $stringCharacterPointer */
    private $stringCharacterPointer;

    public function setUp()
    {
        $this->stringCharacterPointer = new StringCharacterPointer();
    }

    /**
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testSetStringSetsTheGivenString()
    {
        $this->stringCharacterPointer->setString('ABC');

        $this->assertEquals('ABC', $this->stringCharacterPointer->getString());
    }

    /**
     * @expectedException \Tools\Exceptions\EmptyStringParameterException
     * @expectedExceptionMessage The string parameter must not be empty.
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testSetStringThrowsIfTheGivenStringIsEmpty()
    {
        $this->stringCharacterPointer->setString('');
    }

    /**
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws OperationOnEmptyStringException
     */
    public function testSetStringSetsPointedCharacterIndexToZeroIfNoInitialIndexIsGiven()
    {
        $this->stringCharacterPointer->setString('ABC');

        $this->assertEquals(0, $this->stringCharacterPointer->getPointedCharacterIndex());
    }

    /**
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws OperationOnEmptyStringException
     */
    public function testSetStringSetsTheGivenInitialPointedCharacterIndex()
    {
        $this->stringCharacterPointer->setString('ABC', 2);

        $this->assertEquals(2, $this->stringCharacterPointer->getPointedCharacterIndex());
    }

    /**
     * @return array
     */
    public function initialPointedCharacterIndexOutOfBoundsDataProvider(): array
    {
        return [
            ['A', -1],
            ['A',  1]
        ];
    }

    /**
     * @expectedException \Tools\Exceptions\StringCharacterIndexOutOfBoundsException
     * @dataProvider initialPointedCharacterIndexOutOfBoundsDataProvider
     * @param string $string
     * @param int $initialPointedCharacterIndex
     * @throws EmptyStringParameterException
     */
    public function testSetStringThrowsIfInitialPointedCharacterIndexBoundsExceeded(
        string $string,
        int $initialPointedCharacterIndex
    ) {
        $characterIndexUpperBound = strlen($string) - 1;
        $this->expectExceptionMessage(
            sprintf(
                'The given character index is outside the string bounds [0, %s]: %s.',
                $characterIndexUpperBound,
                $initialPointedCharacterIndex
            )
        );

        $this->stringCharacterPointer->setString($string, $initialPointedCharacterIndex);
    }

    /**
     * @return array
     */
    public function pointedCharacterDataProvider(): array
    {
        return [
            [0, 'A'],
            [1, 'B'],
            [2, 'C']
        ];
    }

    /**
     * @dataProvider pointedCharacterDataProvider
     * @param int $initialPointedCharacterIndex
     * @param string $expectedPointedCharacter
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws OperationOnEmptyStringException
     */
    public function testGetPointedCharacterReturnsTheCorrectCharacter(
        int $initialPointedCharacterIndex,
        string $expectedPointedCharacter
    ) {
        $this->stringCharacterPointer->setString('ABC', $initialPointedCharacterIndex);

        $this->assertEquals($expectedPointedCharacter, $this->stringCharacterPointer->getPointedCharacter());
    }

    /**
     * @expectedException \Tools\Exceptions\OperationOnEmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     */
    public function testGetPointedCharacterThrowsIfTheStringIsEmpty()
    {
        $this->stringCharacterPointer->getPointedCharacter();
    }

    /**
     * @expectedException \Tools\Exceptions\OperationOnEmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     */
    public function testGetPointedCharacterIndexThrowsIfTheStringIsEmpty()
    {
        $this->stringCharacterPointer->getPointedCharacterIndex();
    }

    public function testIsStringEmptyReturnsTrueIfTheStringIsEmpty()
    {
        $this->assertTrue($this->stringCharacterPointer->isStringEmpty());
    }

    /**
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testIsStringEmptyReturnsFalseIfTheStringIsNotEmpty()
    {
        $this->stringCharacterPointer->setString('ABC');

        $this->assertFalse($this->stringCharacterPointer->isStringEmpty());
    }

    /**
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws OperationOnEmptyStringException
     */
    public function testMoveForwardsSetsThePointedCharacterIndexCorrectly()
    {
        $this->stringCharacterPointer->setString('ABC');
        $this->stringCharacterPointer->moveForwards();

        $this->assertEquals(1, $this->stringCharacterPointer->getPointedCharacterIndex());
    }

    /**
     * @return array
     */
    public function moveForwardsWithMultipleStepsDataProvider(): array
    {
        return [
            [0,  1, 1],
            [0,  2, 2],
            [0,  3, 0],
            [2,  1, 0],
            [2,  2, 1],
            [2,  3, 2],
            [2,  4, 0],
            [0, -1, 2],
            [0, -2, 1],
            [0, -3, 0],
            [0, -4, 2],
            [2, -1, 1],
            [2, -2, 0],
            [2, -3, 2]
        ];
    }

    /**
     * @dataProvider moveForwardsWithMultipleStepsDataProvider
     * @param int $initialPointedCharacterIndex
     * @param int $stepsCount
     * @param int $expectedPointedCharacterIndex
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws OperationOnEmptyStringException
     */
    public function testMoveForwardsWithMultipleStepsSetsThePointedCharacterIndexCorrectly(
        int $initialPointedCharacterIndex,
        int $stepsCount,
        int $expectedPointedCharacterIndex
    ) {
        $this->stringCharacterPointer->setString('ABC', $initialPointedCharacterIndex);
        $this->stringCharacterPointer->moveForwards($stepsCount);

        $this->assertEquals($expectedPointedCharacterIndex, $this->stringCharacterPointer->getPointedCharacterIndex());
    }

    /**
     * @expectedException \Tools\Exceptions\OperationOnEmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     */
    public function testMoveForwardsThrowsIfTheStringIsEmpty()
    {
        $this->stringCharacterPointer->moveForwards();
    }

    /**
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws OperationOnEmptyStringException
     */
    public function testMoveBackwardsSetsThePointedCharacterIndexCorrectly()
    {
        $this->stringCharacterPointer->setString('ABC');
        $this->stringCharacterPointer->moveBackwards();

        $this->assertEquals(2, $this->stringCharacterPointer->getPointedCharacterIndex());
    }

    /**
     * @return array
     */
    public function moveBackwardsWithMultipleStepsDataProvider(): array
    {
        return [
            [0,  1, 2],
            [0,  2, 1],
            [0,  3, 0],
            [0,  4, 2],
            [2,  1, 1],
            [2,  2, 0],
            [2,  3, 2],
            [0, -1, 1],
            [0, -2, 2],
            [0, -3, 0],
            [2, -1, 0],
            [2, -2, 1],
            [2, -3, 2],
            [2, -4, 0]
        ];
    }

    /**
     * @dataProvider moveBackwardsWithMultipleStepsDataProvider
     * @param int $initialPointedCharacterIndex
     * @param int $stepsCount
     * @param int $expectedPointerCharacterIndex
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws OperationOnEmptyStringException
     */
    public function testMoveBackwardsWithMultipleStepsSetsThePointedCharacterIndexCorrectly(
        int $initialPointedCharacterIndex,
        int $stepsCount,
        int $expectedPointerCharacterIndex
    ) {
        $this->stringCharacterPointer->setString('ABC', $initialPointedCharacterIndex);
        $this->stringCharacterPointer->moveBackwards($stepsCount);

        $this->assertEquals($expectedPointerCharacterIndex, $this->stringCharacterPointer->getPointedCharacterIndex());
    }

    /**
     * @expectedException \Tools\Exceptions\OperationOnEmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     */
    public function testMoveBackwardsThrowsIfTheStringIsEmpty()
    {
        $this->stringCharacterPointer->moveBackwards();
    }

    /**
     * @return array
     */
    public function moveToNextCharacterDataProvider(): array
    {
        return [
            ['BABB', 1, 'B', 2],
            ['BBA',  1, 'B', 0],
            ['BA',   1, 'A', 1]
        ];
    }

    /**
     * @dataProvider moveToNextCharacterDataProvider
     * @param string $string
     * @param int $initialPointedCharacterIndex
     * @param string $character
     * @param int $expectedPointedCharacterIndex
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws InvalidCharacterParameterException
     * @throws OperationOnEmptyStringException
     * @throws StringCharacterNotContainedException
     */
    public function testMoveToNextCharacterSetsThePointedCharacterIndexCorrectly(
        string $string,
        int $initialPointedCharacterIndex,
        string $character,
        int $expectedPointedCharacterIndex
    ) {
        $this->stringCharacterPointer->setString($string, $initialPointedCharacterIndex);
        $this->stringCharacterPointer->moveToNextCharacter($character);

        $this->assertEquals($expectedPointedCharacterIndex, $this->stringCharacterPointer->getPointedCharacterIndex());
    }

    /**
     * @expectedException \Tools\Exceptions\StringCharacterNotContainedException
     * @expectedExceptionMessage The character to go to is not contained in the string: a.
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws InvalidCharacterParameterException
     * @throws OperationOnEmptyStringException
     */
    public function testMoveToNextCharacterThrowsIfCharacterIsNotContained()
    {
        $this->stringCharacterPointer->setString('ABC');
        $this->stringCharacterPointer->moveToNextCharacter('a');
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
     * @dataProvider invalidCharacterDataProvider
     * @param string $invalidCharacter
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws OperationOnEmptyStringException
     * @throws StringCharacterNotContainedException
     */
    public function testMoveToNextCharacterThrowsIfTheGivenCharacterIsInvalid(string $invalidCharacter)
    {
        $this->stringCharacterPointer->setString('ABC');

        $this->expectExceptionMessage(
            'The given parameter is not a valid character: ' . $invalidCharacter . '.'
        );

        $this->stringCharacterPointer->moveToNextCharacter($invalidCharacter);
    }

    /**
     * @expectedException \Tools\Exceptions\OperationOnEmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     * @throws InvalidCharacterParameterException
     * @throws StringCharacterNotContainedException
     */
    public function testMoveToNextCharacterThrowsIfTheStringIsEmpty()
    {
        $this->stringCharacterPointer->moveToNextCharacter('A');
    }
}
