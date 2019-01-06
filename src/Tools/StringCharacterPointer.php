<?php
namespace Tools;

class StringCharacterPointer
{
    /** @const int NO_CHARACTER_POINTED */
    const NO_CHARACTER_POINTED = -1;

    /** @var string $string */
    private $string = '';

    /** @var int $pointedCharacterIndex */
    private $pointedCharacterIndex = self::NO_CHARACTER_POINTED;

    /**
     * @param string $string
     * @param int $initialPointedCharacterIndex (default: 0)
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function setString(string $string, int $initialPointedCharacterIndex = 0)
    {
        $upperBoundCharacterIndex = strlen($string) - 1;
        if ($initialPointedCharacterIndex < 0 || $initialPointedCharacterIndex > $upperBoundCharacterIndex) {
            throw new StringCharacterIndexOutOfBoundsException(
                $upperBoundCharacterIndex,
                $initialPointedCharacterIndex
            );
        }

        $this->string = $string;
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
        $stringLength = $this->getStringLength();

        $this->setPointedCharacterIndex(
            ($this->pointedCharacterIndex + $stepsCount % $stringLength + $stringLength) % $stringLength
        );
    }

    /**
     * @return int
     */
    private function getStringLength(): int
    {
        return strlen($this->getString());
    }

    /**
     * @return string
     */
    public function getString(): string
    {
        return $this->string;
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
        return $this->string[$this->getPointedCharacterIndex()];
    }

    /**
     * @return int
     */
    public function getPointedCharacterIndex(): int
    {
        return $this->pointedCharacterIndex;
    }
}
