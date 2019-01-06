<?php
namespace Tools;

class TextCharacterPointer
{
    /** @const int NO_CHARACTER_POINTED */
    const NO_CHARACTER_POINTED = -1;

    /** @var string $text */
    private $text = '';

    /** @var int $pointedCharacterIndex */
    private $pointedCharacterIndex = self::NO_CHARACTER_POINTED;

    /**
     * @param string $text
     * @param int $initialPointedCharacterIndex (default: 0)
     * @throws TextCharacterIndexOutOfBoundsException
     */
    public function setText(string $text, int $initialPointedCharacterIndex = 0)
    {
        $upperBoundCharacterIndex = strlen($text) - 1;
        if ($initialPointedCharacterIndex < 0 || $initialPointedCharacterIndex > $upperBoundCharacterIndex) {
            throw new TextCharacterIndexOutOfBoundsException($upperBoundCharacterIndex, $initialPointedCharacterIndex);
        }

        $this->text = $text;
        $this->setPointedCharacterIndex($initialPointedCharacterIndex);
    }

    /**
     * @param int $pointedCharacterIndex
     */
    private function setPointedCharacterIndex(int $pointedCharacterIndex)
    {
        $this->pointedCharacterIndex = $pointedCharacterIndex;
    }

    /**
     * @param int $stepsCount (default: 1)
     */
    public function moveForwards(int $stepsCount = 1)
    {
        $textLength = $this->getTextLength();

        $this->setPointedCharacterIndex(
            ($this->pointedCharacterIndex + $stepsCount % $textLength + $textLength) % $textLength
        );
    }

    /**
     * @return int
     */
    private function getTextLength(): int
    {
        return strlen($this->getText());
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param int $stepsCount (default: 1)
     */  
    public function moveBackwards($stepsCount = 1)
    {
        $this->moveForwards(-$stepsCount);
    }
    
    /**
     * @return string
     */
    public function getPointedCharacter(): string
    {
        return $this->text[$this->getPointedCharacterIndex()];
    }

    /**
     * @return int
     */
    public function getPointedCharacterIndex(): int
    {
        return $this->pointedCharacterIndex;
    }
}
