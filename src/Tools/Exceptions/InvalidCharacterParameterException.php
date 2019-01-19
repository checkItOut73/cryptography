<?php declare(strict_types = 1);

namespace Tools\Exceptions;

class InvalidCharacterParameterException extends \Exception
{
    /**
     * @param string $invalidCharacter
     */
    public function __construct(string $invalidCharacter)
    {
        parent::__construct('The given parameter is not a valid character: ' . $invalidCharacter . '.');
    }
}
