<?php declare(strict_types = 1);

namespace Tools;

use Tools\Exceptions\InvalidCharacterParameterException;
use Tools\Exceptions\OperationOnEmptyStringException;

class StringEditor extends StringReader
{
    /**
     * @param string $character
     * @throws InvalidCharacterParameterException
     * @throws OperationOnEmptyStringException
     */
    public function setPointedCharacter(string $character)
    {
        $this->throwIfCharacterIsInvalid($character);

        $this->string[$this->getPointedCharacterIndex()] = $character;
    }

    /**
     * @throws OperationOnEmptyStringException
     */
    public function removePointedCharacter()
    {
        $this->removeCharacter($this->getPointedCharacterIndex());
    }

    /**
     * @param int $characterIndex
     */
    private function removeCharacter(int $characterIndex)
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
    private function getSubStringBeforeCharacter(int $characterIndex): string
    {
        return substr($this->string, 0, $characterIndex);
    }

    /**
     * @param int $characterIndex
     * @return string
     */
    private function getSubStringAfterCharacter(int $characterIndex): string
    {
        return substr($this->string, $characterIndex + 1);
    }

    /**
     * @throws OperationOnEmptyStringException
     */
    public function removeFirstCharacter()
    {
        $this->throwIfStringIsEmpty();

        $this->removeCharacter(0);
    }

    /**
     * @throws OperationOnEmptyStringException
     */
    public function cutPointedCharacter()
    {
        $this->readPointedCharacter();
        $this->removePointedCharacter();
    }
}
