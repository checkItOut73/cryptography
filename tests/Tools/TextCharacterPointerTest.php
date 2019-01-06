<?php
namespace Tools;

use PHPUnit\Framework\TestCase;

class TextCharacterPointerTest extends TestCase
{
    /** @var TextCharacterPointer $textCharacterPointer */
    private $textCharacterPointer;

    public function setUp()
    {
        $this->textCharacterPointer = new TextCharacterPointer();
    }

    /**
     * @return array
     */
    public function initialPointedCharacterIndexOutOfBoundsDataProvider()
    {
        return [
            ['', 0],
            ['A', -1],
            ['A', 1]
        ];
    }

    /**
     * @expectedException \Tools\TextCharacterIndexOutOfBoundsException
     * @dataProvider initialPointedCharacterIndexOutOfBoundsDataProvider
     * @param string $text
     * @param int $initialPointedCharacterIndex
     */
    public function testSetTextThrowsIfInitialPointedCharacterIndexBoundsExceeded($text, $initialPointedCharacterIndex)
    {
        $upperBoundCharacterIndex = strlen($text) - 1;
        $this->expectExceptionMessage(
            'The given character index is outside the text bounds ' .
                "[0, $upperBoundCharacterIndex]: $initialPointedCharacterIndex."
        );

        $this->textCharacterPointer->setText($text, $initialPointedCharacterIndex);
    }

    /**
     * @throws TextCharacterIndexOutOfBoundsException
     */
    public function testSetTextSetsTheGivenText()
    {
        $this->textCharacterPointer->setText('ABC');

        $this->assertEquals('ABC', $this->textCharacterPointer->getText());
    }

    /**
     * @throws TextCharacterIndexOutOfBoundsException
     */
    public function testSetTextSetsPointedCharacterIndexToZeroIfNoInitialIndexIsGiven()
    {
        $this->textCharacterPointer->setText('ABC');

        $this->assertEquals(0, $this->textCharacterPointer->getPointedCharacterIndex());
    }

    /**
     * @throws TextCharacterIndexOutOfBoundsException
     */
    public function testSetTextSetsTheGivenInitialPointedCharacterIndex()
    {
        $this->textCharacterPointer->setText('ABC', 2);

        $this->assertEquals(2, $this->textCharacterPointer->getPointedCharacterIndex());
    }

    /**
     * @throws TextCharacterIndexOutOfBoundsException
     */
    public function testMoveForwardsSetsThePointedCharacterIndexCorrectly()
    {
        $this->textCharacterPointer->setText('ABC');
        $this->textCharacterPointer->moveForwards();

        $this->assertEquals(1, $this->textCharacterPointer->getPointedCharacterIndex());
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
     * @throws TextCharacterIndexOutOfBoundsException
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
        $this->textCharacterPointer->setText('ABC', $initialPointedCharacterIndex);
        $this->textCharacterPointer->moveForwards($stepsCount);

        $this->assertEquals($expectedPointedCharacterIndex, $this->textCharacterPointer->getPointedCharacterIndex());
    }

    /**
     * @throws TextCharacterIndexOutOfBoundsException
     */
    public function testMoveBackwardsSetsThePointedCharacterIndexCorrectly()
    {
        $this->textCharacterPointer->setText('ABC');
        $this->textCharacterPointer->moveBackwards();

        $this->assertEquals(2, $this->textCharacterPointer->getPointedCharacterIndex());
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
     * @throws TextCharacterIndexOutOfBoundsException
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
        $this->textCharacterPointer->setText('ABC', $initialPointedCharacterIndex);
        $this->textCharacterPointer->moveBackwards($stepsCount);

        $this->assertEquals($expectedPointerCharacterIndex, $this->textCharacterPointer->getPointedCharacterIndex());
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
     * @throws TextCharacterIndexOutOfBoundsException
     * @dataProvider pointedCharacterDataProvider
     * @param int $initialPointedCharacterIndex
     * @param string $expectedPointedCharacter
     */
    public function testGetPointedCharacterReturnsTheCorrectCharacter(
        $initialPointedCharacterIndex,
        $expectedPointedCharacter
    ) {
        $this->textCharacterPointer->setText('ABC', $initialPointedCharacterIndex);

        $this->assertEquals($expectedPointedCharacter, $this->textCharacterPointer->getPointedCharacter());
    }
}
