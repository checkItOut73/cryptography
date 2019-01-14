<?php
namespace Tools;

class StringBuffer
{
    /** @var string $string */
    private $string;

    /**
     * @param string $string (default: '')
     */
    public function __construct($string = '')
    {
        $this->string = $string;
    }

    /**
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * @param string $string
     */
    public function appendString($string)
    {
        $this->string .= $string;
    }

    public function flush()
    {
        $this->string = '';
    }
}
