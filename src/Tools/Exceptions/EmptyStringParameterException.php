<?php declare(strict_types = 1);

namespace Tools\Exceptions;

class EmptyStringParameterException extends \Exception
{
    public function __construct()
    {
        parent::__construct('The string parameter must not be empty.');
    }
}
