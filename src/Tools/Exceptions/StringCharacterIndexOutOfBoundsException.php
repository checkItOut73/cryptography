<?php declare(strict_types = 1);

namespace Tools\Exceptions;

class StringCharacterIndexOutOfBoundsException extends \Exception
{
    /**
     * @param int $characterIndexUpperBound
     * @param int $characterIndex
     */
    public function __construct(int $characterIndexUpperBound, int $characterIndex)
    {
        parent::__construct(
            'The given character index is outside the string bounds ' .
                '[0, ' . $characterIndexUpperBound . ']: ' . $characterIndex . '.'
        );
    }
}
