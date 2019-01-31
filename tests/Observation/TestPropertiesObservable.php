<?php declare(strict_types = 1);

namespace Observation;

class TestPropertiesObservable
{
    use PropertiesObservableTrait;

    /** @var string $name */
    private $name;

    /**
     * @return string[]
     */
    protected function getObservedPropertyNames(): array
    {
        return ['name'];
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
}
