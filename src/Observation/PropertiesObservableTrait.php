<?php declare(strict_types = 1);

namespace Observation;

trait PropertiesObservableTrait
{
    use ObservableTrait;

    /** @var array $observedProperties */
    private $observedProperties = [];

    public function __construct()
    {
        foreach ($this->getObservedPropertyNames() as $observedPropertyName) {
            $this->observedProperties[$observedPropertyName] = $this->$observedPropertyName;
            unset($this->$observedPropertyName);
        }
    }

    /**
     * @return string[]
     */
    private function getObservedPropertyNames(): array
    {
        return array_keys($this->getObservedPropertiesChangeActionCreators());
    }

    /**
     * @return array
     */
    abstract protected function getObservedPropertiesChangeActionCreators(): array;

    /**
     * @param string $propertyName
     * @return bool
     */
    public function __isset(string $propertyName): bool
    {
        return $this->isObservedProperty($propertyName) ? isset($this->observedProperties[$propertyName]) : false;
    }

    /**
     * @param string $propertyName
     * @return bool
     */
    private function isObservedProperty(string $propertyName): bool
    {
        return in_array($propertyName, $this->getObservedPropertyNames());
    }

    /**
     * @param string $propertyName
     * @return mixed
     */
    public function __get(string $propertyName)
    {
        $propertyValue = null;

        if ($this->isObservedProperty($propertyName)) {
            $propertyValue = $this->observedProperties[$propertyName];
        }

        return $propertyValue;
    }

    /**
     * @param string $propertyName
     * @param mixed $propertyValue
     */
    public function __set(string $propertyName, $propertyValue)
    {
        if ($this->isObservedProperty($propertyName)) {
            $this->observedProperties[$propertyName] = $propertyValue;

            $actionCreators = $this->getObservedPropertiesChangeActionCreators();
            $this->notifyObservers($actionCreators[$propertyName]($propertyName));
        }
    }
}
