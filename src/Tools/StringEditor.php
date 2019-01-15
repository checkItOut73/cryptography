<?php
namespace Tools;

use Tools\Exceptions\InvalidCharacterException;
use Tools\Exceptions\EmptyStringException;
use Tools\Exceptions\StringCharacterIndexOutOfBoundsException;

class StringEditor extends StringReader
{
    /**
     * @param string $character
     * @throws InvalidCharacterException
     * @throws EmptyStringException
     */
    public function setPointedCharacter($character)
    {
        $this->throwIfCharacterIsInvalid($character);

        $this->string[$this->getPointedCharacterIndex()] = $character;
    }

    /**
     * @throws EmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function removePointedCharacter()
    {
        $this->string = $this->getSubStringBeforePointer() . $this->getSubStringAfterPointer();

        if ($this->getPointedCharacterIndex() === $this->getCharacterIndexUpperBound() + 1) {
            $this->moveBackwards();
        }
    }

    /**
     * @return string
     * @throws EmptyStringException
     */
    private function getSubStringBeforePointer()
    {
        return substr($this->string, 0, $this->getPointedCharacterIndex());
    }

    /**
     * @return string
     * @throws EmptyStringException
     */
    private function getSubStringAfterPointer()
    {
        return substr($this->string, $this->getPointedCharacterIndex() + 1);
    }

    // TODO removeFirstCharacter
    // TODO cutPointedCharacter
}
