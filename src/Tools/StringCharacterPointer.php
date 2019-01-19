<?php
namespace Tools;

use Tools\Exceptions\EmptyStringParameterException;
use Tools\Exceptions\OperationOnEmptyStringException;
use Tools\Exceptions\StringCharacterIndexOutOfBoundsException;
use Tools\Exceptions\InvalidCharacterParameterException;
use Tools\Exceptions\StringCharacterNotContainedException;

class StringCharacterPointer
{
    /** @var string $string */
    protected $string = '';

    /** @var int $pointedCharacterIndex */
    protected $pointedCharacterIndex;

    /**
     * @param string $string
     * @param int $initialPointedCharacterIndex
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function setString($string, $initialPointedCharacterIndex = 0)
    {
        $this->throwIfStringParameterIsEmpty($string);
        $this->string = $string;

        $this->throwIfCharacterIndexIsOutOfBounds($initialPointedCharacterIndex);
        $this->pointedCharacterIndex = $initialPointedCharacterIndex;
    }

    /**
     * @param string $string
     * @throws EmptyStringParameterException
     */
    private function throwIfStringParameterIsEmpty($string)
    {
        if (empty($string)) {
            throw new EmptyStringParameterException();
        }
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
     * @return int
     */
    private function getStringLength()
    {
        return strlen($this->string);
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
     * @throws OperationOnEmptyStringException
     */
    public function getPointedCharacter()
    {
        return $this->string[$this->getPointedCharacterIndex()];
    }

    /**
     * @return int
     * @throws OperationOnEmptyStringException
     */
    public function getPointedCharacterIndex()
    {
        $this->throwIfStringIsEmpty();

        return $this->pointedCharacterIndex;
    }

    /**
     * @throws OperationOnEmptyStringException
     */
    protected function throwIfStringIsEmpty()
    {
        if (empty($this->string)) {
            throw new OperationOnEmptyStringException();
        }
    }

    /**
     * @param int $stepsCount (default: 1)
     * @throws OperationOnEmptyStringException
     */
    public function moveForwards($stepsCount = 1)
    {
        $this->throwIfStringIsEmpty();

        $stringLength = $this->getStringLength();

        $this->pointedCharacterIndex =
            ($this->pointedCharacterIndex + $stepsCount % $stringLength + $stringLength) % $stringLength;
    }

    /**
     * @param int $stepsCount (default: 1)
     * @throws OperationOnEmptyStringException
     */
    public function moveBackwards($stepsCount = 1)
    {
        $this->moveForwards(-$stepsCount);
    }

    /**
     * @param string $character
     * @throws InvalidCharacterParameterException
     * @throws OperationOnEmptyStringException
     * @throws StringCharacterNotContainedException
     */
    public function moveToNextCharacter($character)
    {
        $this->throwIfCharacterIsInvalid($character);
        $this->throwIfStringIsEmpty();

        $nextCharacterIndexAfter = strpos($this->string, $character, $this->pointedCharacterIndex + 1);

        if (false !== $nextCharacterIndexAfter) {
            $this->pointedCharacterIndex = $nextCharacterIndexAfter;
        } else {
            $nextCharacterIndexBefore = strpos(
                substr($this->string, 0, $this->pointedCharacterIndex + 1),
                $character
            );

            if (false !== $nextCharacterIndexBefore) {
                $this->pointedCharacterIndex = $nextCharacterIndexBefore;
            } else {
                throw new StringCharacterNotContainedException($character);
            }
        }
    }

    /**
     * @param string $character
     * @throws InvalidCharacterParameterException
     */
    protected function throwIfCharacterIsInvalid($character)
    {
        if (1 !== strlen($character)) {
            throw new InvalidCharacterParameterException($character);
        }
    }
}
