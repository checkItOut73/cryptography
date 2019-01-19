<?php
namespace Tools\Exceptions;

class InvalidCharacterParameterException extends \Exception
{
    /**
     * @param string $invalidCharacter
     */
    public function __construct($invalidCharacter)
    {
        parent::__construct('The given parameter is not a valid character: ' . $invalidCharacter . '.');
    }
}
