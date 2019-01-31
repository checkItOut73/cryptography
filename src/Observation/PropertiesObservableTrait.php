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
    abstract protected function getObservedPropertyNames(): array;

    /**
     * @param string $propertyName
     * @return mixed
     */
    public function __get(string $propertyName)
    {
        $propertyValue = null;

        if ($this->isObservedProperty($propertyName)) {
            $propertyValue = $this->observedProperties[$propertyName];
        } elseif (property_exists($this, $propertyName)) {
            $propertyValue = $this->$propertyName;
        }

        return $propertyValue;
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
     * @param mixed $propertyValue
     */
    public function __set(string $propertyName, $propertyValue)
    {
        if ($this->isObservedProperty($propertyName)) {
            $this->notifyObservers(new PropertyChangedAction([$propertyName => $propertyValue]));
            $this->observedProperties[$propertyName] = $propertyValue;
        } elseif (property_exists($this, $propertyName)) {
            $this->$propertyName = $propertyValue;
        }
    }
}
