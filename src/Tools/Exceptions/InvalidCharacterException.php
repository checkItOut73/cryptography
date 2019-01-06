<?php
namespace Tools\Exceptions;

class InvalidCharacterException extends \Exception
{
    /**
     * @param string $invalidCharacter
     */
    public function __construct($invalidCharacter)
    {
        parent::__construct('The given argument is not a valid character: ' . $invalidCharacter . '.');
    }
}
