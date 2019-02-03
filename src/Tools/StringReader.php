<?php declare(strict_types = 1);

namespace Tools;

use Tools\Exceptions\InvalidCharacterParameterException;
use Tools\Exceptions\OperationOnEmptyStringException;

class StringReader extends StringCharacterPointer
{
    /** @var string $readString */
    protected $readString = '';

    /**
     * @param string $character
     * @return bool
     * @throws InvalidCharacterParameterException
     * @throws OperationOnEmptyStringException
     */
    public function isCharacterContained(string $character): bool
    {
        $this->throwIfCharacterIsInvalid($character);
        $this->throwIfStringIsEmpty();

        return false !== strpos($this->string, $character);
    }

    /**
     * @throws OperationOnEmptyStringException
     */
    public function readPointedCharacter()
    {
        $this->readString .= $this->getPointedCharacter();
    }

    /**
     * @return string
     */
    public function getReadString(): string
    {
        return $this->readString;
    }

    public function flushReadString()
    {
        $this->readString = '';
    }

    /**
     * @return string
     */
    public function getFlushedReadString(): string
    {
        $readString = $this->readString;

        $this->flushReadString();

        return $readString;
    }
}
