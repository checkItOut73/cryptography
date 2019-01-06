<?php
namespace Tools;

use Tools\Exceptions\EmptyStringException;
use Tools\Exceptions\StringCharacterIndexOutOfBoundsException;

class StringCharacterPointer
{
    /** @var string $string */
    private $string = '';

    /** @var int $pointedCharacterIndex */
    private $pointedCharacterIndex;

    /**
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     * @param string $string
     * @param int $initialPointedCharacterIndex (default: 0)
     */
    public function setString($string, $initialPointedCharacterIndex = 0)
    {
        $this->string = $string;
        $this->setPointedCharacterIndex($initialPointedCharacterIndex);
    }

    /**
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     * @param int $pointedCharacterIndex
     */
    private function setPointedCharacterIndex($pointedCharacterIndex)
    {
        $this->throwIfStringIsEmpty();
        $this->throwIfCharacterIndexIsOutOfBounds($pointedCharacterIndex);

        $this->pointedCharacterIndex = $pointedCharacterIndex;
    }

    /**
     * @throws EmptyStringException
     */
    private function throwIfStringIsEmpty()
    {
        if (0 === $this->getStringLength()) {
            throw new EmptyStringException();
        }
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
     * @throws StringCharacterIndexOutOfBoundsException
     * @param int characterIndex
     */
    private function throwIfCharacterIndexIsOutOfBounds($characterIndex)
    {
        $upperBoundCharacterIndex = $this->getStringLength() - 1;
        if ($characterIndex < 0 || $characterIndex > $upperBoundCharacterIndex) {
            throw new StringCharacterIndexOutOfBoundsException(
                $upperBoundCharacterIndex,
                $characterIndex
            );
        }
    }

    /**
     * @throws EmptyStringException
     * @return string
     */
    public function getPointedCharacter()
    {
        return $this->string[$this->getPointedCharacterIndex()];
    }

    /**
     * @throws EmptyStringException
     * @return int
     */
    public function getPointedCharacterIndex()
    {
        $this->throwIfStringIsEmpty();

        return $this->pointedCharacterIndex;
    }

    /**
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     * @param int $stepsCount (default: 1)
     */
    public function moveForwards($stepsCount = 1)
    {
        $this->throwIfStringIsEmpty();

        $stringLength = $this->getStringLength();

        $this->setPointedCharacterIndex(
            ($this->pointedCharacterIndex + $stepsCount % $stringLength + $stringLength) % $stringLength
        );
    }

    /**
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     * @param int $stepsCount (default: 1)
     */
    public function moveBackwards($stepsCount = 1)
    {
        $this->moveForwards(-$stepsCount);
    }
}
