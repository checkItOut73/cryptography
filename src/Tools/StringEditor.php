<?php
namespace Tools;

use Tools\Exceptions\InvalidCharacterException;
use Tools\Exceptions\EmptyStringException;

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
     */
    public function removePointedCharacter()
    {
        $this->removeCharacter($this->getPointedCharacterIndex());
    }

    /**
     * @param int $characterIndex
     */
    private function removeCharacter($characterIndex)
    {
        $this->string = (
            $this->getSubStringBeforeCharacter($characterIndex) .
            $this->getSubStringAfterCharacter($characterIndex)
        );

        if ($this->pointedCharacterIndex > $characterIndex) {
            $this->pointedCharacterIndex--;
        } elseif ($this->pointedCharacterIndex === $this->getCharacterIndexUpperBound() + 1) {
            $this->pointedCharacterIndex = 0;
        }
    }

    /**
     * @param int $characterIndex
     * @return string
     */
    private function getSubStringBeforeCharacter($characterIndex)
    {
        return substr($this->string, 0, $characterIndex);
    }

    /**
     * @param int $characterIndex
     * @return string
     */
    private function getSubStringAfterCharacter($characterIndex)
    {
        return substr($this->string, $characterIndex + 1);
    }

    /**
     * @throws EmptyStringException
     */
    public function removeFirstCharacter()
    {
        $this->throwIfStringIsEmpty();

        $this->removeCharacter(0);
    }

    /**
     * @throws EmptyStringException
     */
    public function cutPointedCharacter()
    {
        $this->readPointedCharacter();
        $this->removePointedCharacter();
    }
}
