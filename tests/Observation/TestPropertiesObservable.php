<?php declare(strict_types = 1);

namespace Observation;

class TestPropertiesObservable
{
    use PropertiesObservableTrait;

    /** @var string $name */
    private $name;

    /** @var string $nonObservedProperty */
    private $nonObservedProperty;

    /**
     * @return string[]
     */
    protected function getObservedPropertyNames(): array
    {
        return ['name'];
    }
    /**
     * @param string $propertyName
     * @return Action
     */
    protected function getPropertyChangedAction(string $propertyName): Action
    {
        return new PropertyChangedAction([$propertyName => $this->$propertyName]);
    }

    /**
     * @param string $propertyName
     * @return bool
     */
    public function isPropertySet(string $propertyName): bool
    {
        return isset($this->$propertyName);
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $nonObservedProperty
     */
    public function setNonObservedProperty(string $nonObservedProperty)
    {
        $this->nonObservedProperty = $nonObservedProperty;
    }
}
