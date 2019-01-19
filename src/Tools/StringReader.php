<?php
namespace Tools;

use Tools\Exceptions\InvalidCharacterParameterException;
use Tools\Exceptions\OperationOnEmptyStringException;

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
     * @throws InvalidCharacterParameterException
     * @throws OperationOnEmptyStringException
     */
    public function isCharacterContained($character)
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
        $this->readStringBuffer->appendString($this->getPointedCharacter());
    }
}
