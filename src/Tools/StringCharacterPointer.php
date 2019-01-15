<?php
namespace Tools;

use Tools\Exceptions\EmptyStringException;
use Tools\Exceptions\StringCharacterIndexOutOfBoundsException;
use Tools\Exceptions\InvalidCharacterException;
use Tools\Exceptions\StringCharacterNotContainedException;

class StringCharacterPointer
{
    /** @var string $string */
    protected $string = '';

    /** @var int $pointedCharacterIndex */
    protected $pointedCharacterIndex;

    /**
     * @param string $string
     * @param int $initialPointedCharacterIndex (default: 0)
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function setString($string, $initialPointedCharacterIndex = 0)
    {
        $this->string = $string;
        $this->setPointedCharacterIndex($initialPointedCharacterIndex);
    }

    /**
     * @param int $pointedCharacterIndex
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
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
    protected function throwIfStringIsEmpty()
    {
        if (0 === $this->getStringLength()) {
            throw new EmptyStringException();
        }
    }

    /**
     * @return int
     */
    protected function getStringLength()
    {
        return strlen($this->string);
    }

    /**
     * @param int characterIndex
     * @throws StringCharacterIndexOutOfBoundsException
     */
    private function throwIfCharacterIndexIsOutOfBounds($characterIndex)
    {
        $characterIndexUpperBound = $this->getCharacterIndexUpperBound();
        if ($characterIndex < 0 || $characterIndex > $characterIndexUpperBound) {
            throw new StringCharacterIndexOutOfBoundsException(
                $characterIndexUpperBound,
                $characterIndex
            );
        }
    }

    /**
     * @return int
     */
    protected function getCharacterIndexUpperBound()
    {
        return $this->getStringLength() - 1;
    }

    /**
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * @return string
     * @throws EmptyStringException
     */
    public function getPointedCharacter()
    {
        return $this->string[$this->getPointedCharacterIndex()];
    }

    /**
     * @return int
     * @throws EmptyStringException
     */
    public function getPointedCharacterIndex()
    {
        $this->throwIfStringIsEmpty();

        return $this->pointedCharacterIndex;
    }

    /**
     * @param int $stepsCount (default: 1)
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
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
     * @param int $stepsCount (default: 1)
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function moveBackwards($stepsCount = 1)
    {
        $this->moveForwards(-$stepsCount);
    }

    /**
     * @param string $character
     * @throws InvalidCharacterException
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws StringCharacterNotContainedException
     */
    public function moveToNextCharacter($character)
    {
        $this->throwIfCharacterIsInvalid($character);

        $nextCharacterIndexAfter = strpos($this->string, $character, $this->getPointedCharacterIndex() + 1);

        if (false !== $nextCharacterIndexAfter) {
            $this->setPointedCharacterIndex($nextCharacterIndexAfter);
        } else {
            $nextCharacterIndexBefore = strpos(
                substr($this->string, 0, $this->getPointedCharacterIndex() + 1),
                $character
            );

            if (false !== $nextCharacterIndexBefore) {
                $this->setPointedCharacterIndex($nextCharacterIndexBefore);
            } else {
                throw new StringCharacterNotContainedException($character);
            }
        }
    }

    /**
     * @param string $character
     * @throws InvalidCharacterException
     */
    protected function throwIfCharacterIsInvalid($character)
    {
        if (1 !== strlen($character)) {
            throw new InvalidCharacterException($character);
        }
    }
}
