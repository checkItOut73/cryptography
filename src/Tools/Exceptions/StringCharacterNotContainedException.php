<?php declare(strict_types = 1);

namespace Tools\Exceptions;

class StringCharacterNotContainedException extends \Exception
{
    /**
     * @param string $character
     */
    public function __construct(string $character)
    {
        parent::__construct('The character to go to is not contained in the string: ' . $character . '.');
    }
}
