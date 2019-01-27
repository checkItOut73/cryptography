<?php declare(strict_types = 1);

namespace Observation;

class Action
{
    /** @var string $name */
    private $name = '';

    /** @var mixed[] $data */
    private $data = [];

    /**
     * @param string $name
     * @param mixed[] $data
     */
    public function __construct(string $name, array $data = [])
    {
        $this->name = $name;
        $this->data = $data;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @return mixed[]
     */
    public function getData(): array
    {
        return $this->data;
    }
    
    /**
     * @param string $methodName
     * @param array $parameters
     * @return mixed
     */
    public function __call(string $methodName, array $parameters)
    {
        if (0 === strpos($methodName, 'get')) {
            $propertyName = lcfirst(substr($methodName, 3));

            return $this->data[$propertyName];
        }
    }
}
