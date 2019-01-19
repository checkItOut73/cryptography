<?php declare(strict_types = 1);

namespace Tools;

class StringBuffer
{
    /** @var string $string */
    private $string;

    /**
     * @param string $string
     */
    public function __construct(string $string = '')
    {
        $this->string = $string;
    }

    /**
     * @return string
     */
    public function getString(): string
    {
        return $this->string;
    }

    /**
     * @param string $string
     */
    public function appendString(string $string)
    {
        $this->string .= $string;
    }

    public function flush()
    {
        $this->string = '';
    }
}
