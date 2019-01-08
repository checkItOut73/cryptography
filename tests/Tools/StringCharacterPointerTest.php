<?php
namespace Tools;

use PHPUnit\Framework\TestCase;
use Tools\Exceptions\EmptyStringException;
use Tools\Exceptions\StringCharacterIndexOutOfBoundsException;
use Tools\Exceptions\InvalidCharacterException;
use Tools\Exceptions\StringCharacterNotContainedException;

class StringCharacterPointerTest extends TestCase
{
    /** @var StringCharacterPointer $stringCharacterPointer */
    private $stringCharacterPointer;

    public function setUp()
    {
        $this->stringCharacterPointer = new StringCharacterPointer();
    }

    /**
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testSetStringSetsTheGivenString()
    {
        $this->stringCharacterPointer->setString('ABC');

        $this->assertEquals('ABC', $this->stringCharacterPointer->getString());
    }

    /**
     * @expectedException \Tools\Exceptions\EmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testSetStringThrowsIfTheGivenStringIsEmpty()
    {
        $this->stringCharacterPointer->setString('');
    }

    /**
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testSetStringSetsPointedCharacterIndexToZeroIfNoInitialIndexIsGiven()
    {
        $this->stringCharacterPointer->setString('ABC');

        $this->assertEquals(0, $this->stringCharacterPointer->getPointedCharacterIndex());
    }

    /**
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testSetStringSetsTheGivenInitialPointedCharacterIndex()
    {
        $this->stringCharacterPointer->setString('ABC', 2);

        $this->assertEquals(2, $this->stringCharacterPointer->getPointedCharacterIndex());
    }


    /**
     * @return array
     */
    public function initialPointedCharacterIndexOutOfBoundsDataProvider()
    {
        return [
            ['A', -1],
            ['A', 1]
        ];
    }

    /**
     * @expectedException \Tools\Exceptions\StringCharacterIndexOutOfBoundsException
     * @throws EmptyStringException
     * @dataProvider initialPointedCharacterIndexOutOfBoundsDataProvider
     * @param string $string
     * @param int $initialPointedCharacterIndex
     */
    public function testSetStringThrowsIfInitialPointedCharacterIndexBoundsExceeded(
        $string,
        $initialPointedCharacterIndex
    ) {
        $upperBoundCharacterIndex = strlen($string) - 1;
        $this->expectExceptionMessage(
            'The given character index is outside the string bounds ' .
                "[0, $upperBoundCharacterIndex]: $initialPointedCharacterIndex."
        );

        $this->stringCharacterPointer->setString($string, $initialPointedCharacterIndex);
    }

    /**
     * @return array
     */
    public function pointedCharacterDataProvider()
    {
        return [
            [0, 'A'],
            [1, 'B'],
            [2, 'C']
        ];
    }

    /**
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     * @dataProvider pointedCharacterDataProvider
     * @param int $initialPointedCharacterIndex
     * @param string $expectedPointedCharacter
     */
    public function testGetPointedCharacterReturnsTheCorrectCharacter(
        $initialPointedCharacterIndex,
        $expectedPointedCharacter
    ) {
        $this->stringCharacterPointer->setString('ABC', $initialPointedCharacterIndex);

        $this->assertEquals($expectedPointedCharacter, $this->stringCharacterPointer->getPointedCharacter());
    }

    /**
     * @expectedException \Tools\Exceptions\EmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     */
    public function testGetPointedCharacterThrowsIfTheStringIsEmpty()
    {
        $this->stringCharacterPointer->getPointedCharacter();
    }

    /**
     * @expectedException \Tools\Exceptions\EmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     */
    public function testGetPointedCharacterIndexThrowsIfTheStringIsEmpty()
    {
        $this->stringCharacterPointer->getPointedCharacterIndex();
    }

    /**
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
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
    public function moveForwardsWithMultipleStepsDataProvider()
    {
        return [
            [0, 1, 1],
            [0, 2, 2],
            [0, 3, 0],
            [2, 1, 0],
            [2, 2, 1],
            [2, 3, 2],
            [2, 4, 0],
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
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     * @dataProvider moveForwardsWithMultipleStepsDataProvider
     * @param int $initialPointedCharacterIndex
     * @param int $stepsCount
     * @param int $expectedPointedCharacterIndex
     */
    public function testMoveForwardsWithMultipleStepsSetsThePointedCharacterIndexCorrectly(
        $initialPointedCharacterIndex,
        $stepsCount,
        $expectedPointedCharacterIndex
    ) {
        $this->stringCharacterPointer->setString('ABC', $initialPointedCharacterIndex);
        $this->stringCharacterPointer->moveForwards($stepsCount);

        $this->assertEquals($expectedPointedCharacterIndex, $this->stringCharacterPointer->getPointedCharacterIndex());
    }

    /**
     * @throws StringCharacterIndexOutOfBoundsException
     * @expectedException \Tools\Exceptions\EmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     */
    public function testMoveForwardsThrowsIfTheStringIsEmpty()
    {
        $this->stringCharacterPointer->moveForwards();
    }

    /**
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
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
    public function moveBackwardsWithMultipleStepsDataProvider()
    {
        return [
            [0, 1, 2],
            [0, 2, 1],
            [0, 3, 0],
            [0, 4, 2],
            [2, 1, 1],
            [2, 2, 0],
            [2, 3, 2],
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
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     * @dataProvider moveBackwardsWithMultipleStepsDataProvider
     * @param int $initialPointedCharacterIndex
     * @param int $stepsCount
     * @param int $expectedPointerCharacterIndex
     */
    public function testMoveBackwardsWithMultipleStepsSetsThePointedCharacterIndexCorrectly(
        $initialPointedCharacterIndex,
        $stepsCount,
        $expectedPointerCharacterIndex
    ) {
        $this->stringCharacterPointer->setString('ABC', $initialPointedCharacterIndex);
        $this->stringCharacterPointer->moveBackwards($stepsCount);

        $this->assertEquals($expectedPointerCharacterIndex, $this->stringCharacterPointer->getPointedCharacterIndex());
    }

    /**
     * @throws StringCharacterIndexOutOfBoundsException
     * @expectedException \Tools\Exceptions\EmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     */
    public function testMoveBackwardsThrowsIfTheStringIsEmpty()
    {
        $this->stringCharacterPointer->moveBackwards();
    }

    /**
     * @return array
     */
    public function moveToNextCharacterDataProvider()
    {
        return [
            ['BABB', 1, 'B', 2],
            ['BBA', 1, 'B', 0],
            ['BA', 1, 'A', 1]
        ];
    }

    /**
     * @throws EmptyStringException
     * @throws InvalidCharacterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws StringCharacterNotContainedException
     * @dataProvider moveToNextCharacterDataProvider
     * @param string $string
     * @param int $initialPointedCharacterIndex
     * @param string $character
     * @param int $expectedPointedCharacterIndex
     */
    public function testMoveToNextCharacterSetsThePointedCharacterIndexCorrectly(
        $string,
        $initialPointedCharacterIndex,
        $character,
        $expectedPointedCharacterIndex
    ) {
        $this->stringCharacterPointer->setString($string, $initialPointedCharacterIndex);
        $this->stringCharacterPointer->moveToNextCharacter($character);

        $this->assertEquals($expectedPointedCharacterIndex, $this->stringCharacterPointer->getPointedCharacterIndex());
    }

    /**
     * @expectedException \Tools\Exceptions\StringCharacterNotContainedException
     * @expectedExceptionMessage The character to go to is not contained in the string: a.
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws InvalidCharacterException
     */
    public function testMoveToNextCharacterThrowsIfCharacterIsNotContained()
    {
        $this->stringCharacterPointer->setString('ABC');
        $this->stringCharacterPointer->moveToNextCharacter('a');
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
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws StringCharacterNotContainedException
     * @dataProvider invalidCharacterDataProvider
     * @param string $invalidCharacter
     */
    public function testMoveToNextCharacterThrowsIfTheGivenCharacterIsInvalid($invalidCharacter)
    {
        $this->stringCharacterPointer->setString('ABC');

        $this->expectExceptionMessage(
            'The given argument is not a valid character: ' . $invalidCharacter. '.'
        );

        $this->stringCharacterPointer->moveToNextCharacter($invalidCharacter);
    }

    /**
     * @expectedException \Tools\Exceptions\EmptyStringException
     * @expectedExceptionMessage The requested operation cannot be processed because the string is empty.
     * @throws InvalidCharacterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws StringCharacterNotContainedException
     */
    public function testMoveToNextCharacterThrowsIfTheStringIsEmpty()
    {
        $this->stringCharacterPointer->moveToNextCharacter('A');
    }
}
