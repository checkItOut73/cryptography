<?php declare(strict_types = 1);

namespace Observation;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Observation\PropertiesObservableTrait
 */
class PropertiesObservableTraitTest extends TestCase
{
    /** @var TestPropertiesObservable $testPropertiesObservable */
    private $testPropertiesObservable;

    /** @var TestObserverSpy $testObserverSpy */
    private $testObserverSpy;

    public function setUp()
    {
        $this->testPropertiesObservable = new TestPropertiesObservable();

        $this->testObserverSpy = new TestObserverSpy();
        $this->testPropertiesObservable->addObserver($this->testObserverSpy);
    }

    public function testObservedPropertiesAreChangedCorrectly()
    {
        $this->testPropertiesObservable->setName('some name');

        $this->assertEquals('some name', $this->testPropertiesObservable->getName());
    }

    public function testIssetReturnsTrueForObservedPropertiesThatAreSet()
    {
        $this->testPropertiesObservable->setName('some name');

        $this->assertTrue($this->testPropertiesObservable->isPropertySet('name'));
    }

    public function testIssetReturnsFalseForObservedPropertiesThatAreNotSet()
    {
        $this->assertFalse($this->testPropertiesObservable->isPropertySet('name'));
    }

    public function testIssetReturnsTrueForOtherNonObservedPropertiesThatAreSet()
    {
        $this->testPropertiesObservable->setNonObservedProperty('some value');

        $this->assertTrue($this->testPropertiesObservable->isPropertySet('nonObservedProperty'));
    }

    public function testIssetReturnsFalseForOtherNonObservedPropertiesThatAreNotSet()
    {
        $this->assertFalse($this->testPropertiesObservable->isPropertySet('nonObservedProperty'));
    }

    public function testIssetReturnsFalseForUndefinedProperties()
    {
        $this->assertFalse($this->testPropertiesObservable->isPropertySet('undefinedProperty'));
    }

    public function testTheSubscribedObservesWillBeNotifiedIfAnObservedPropertyChanges()
    {
        $action = new PropertyChangedAction(['name' => 'new name']);

        $this->testPropertiesObservable->setName('new name');

        $this->assertTrue($this->testObserverSpy->hasMethodBeenCalledWith('handleAction', [$action], false));
    }
}
