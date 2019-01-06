<?php
namespace Tools;

class StringCharacterIndexOutOfBoundsException extends \Exception
{
    /**
     * @param int $upperBoundCharacterIndex
     * @param int $characterIndex
     */
    public function __construct($upperBoundCharacterIndex, $characterIndex)
    {
        parent::__construct(
            'The given character index is outside the string bounds ' .
                '[0, ' . $upperBoundCharacterIndex . ']: ' . $characterIndex . '.'
        );
    }
}
