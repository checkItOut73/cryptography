<?php declare(strict_types = 1);

namespace Observation;

class Action
{
    /** @var mixed[] $data */
    private $data = [];

    /**
     * @param mixed[] $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
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
        } else {
            $this->triggerDefaultUndefinedMethodError($methodName);
        }
    } // @codeCoverageIgnore

    /**
     * @param string $methodName
     */
    private function triggerDefaultUndefinedMethodError(string $methodName)
    {
        trigger_error('Call to undefined method ' . __CLASS__ . '::' . $methodName . '()', E_USER_ERROR);
    } // @codeCoverageIgnore
}
