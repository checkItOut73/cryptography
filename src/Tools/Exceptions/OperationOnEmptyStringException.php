<?php
namespace Tools\Exceptions;

class OperationOnEmptyStringException extends \Exception
{
    public function __construct()
    {
        parent::__construct('The requested operation cannot be processed because the string is empty.');
    }
}
