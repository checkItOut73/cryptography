<?php
namespace Tools;

use Tools\Exceptions\InvalidCharacterException;
use Tools\Exceptions\EmptyStringException;

class StringReader extends StringCharacterPointer
{
    /** @var StringBuffer $readStringBuffer */
    private $readStringBuffer;

    /**
     * @param StringBuffer $readStringBuffer
     */
    public function __construct($readStringBuffer)
    {
        $this->readStringBuffer = $readStringBuffer;
    }

    /**
     * @param string $character
     * @return bool
     * @throws InvalidCharacterException
     * @throws EmptyStringException
     */
    public function isCharacterContained($character)
    {
        $this->throwIfCharacterIsInvalid($character);
        $this->throwIfStringIsEmpty();

        return false !== strpos($this->string, $character);
    }

    /**
     * @throws EmptyStringException
     */
    public function readPointedCharacter()
    {
        $this->readStringBuffer->appendString($this->getPointedCharacter());
    }
}
