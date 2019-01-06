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
    public function setString($string, $initialPointedCharacterIndex = 0)
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
    private function setPointedCharacterIndex($pointedCharacterIndex)
    {
        $this->pointedCharacterIndex = $pointedCharacterIndex;
    }

    /**
     * @param int $stepsCount (default: 1)
     */
    public function moveForwards($stepsCount = 1)
    {
        $stringLength = $this->getStringLength();

        $this->setPointedCharacterIndex(
            ($this->pointedCharacterIndex + $stepsCount % $stringLength + $stringLength) % $stringLength
        );
    }

    /**
     * @return int
     */
    private function getStringLength()
    {
        return strlen($this->getString());
    }

    /**
     * @return string
     */
    public function getString()
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
    public function getPointedCharacter()
    {
        return $this->string[$this->getPointedCharacterIndex()];
    }

    /**
     * @return int
     */
    public function getPointedCharacterIndex()
    {
        return $this->pointedCharacterIndex;
    }
}
