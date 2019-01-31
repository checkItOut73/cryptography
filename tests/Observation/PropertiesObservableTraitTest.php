<?php declare(strict_types = 1);

namespace Observation;

use PHPUnit\Framework\TestCase;

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

    public function testTheSubscribedObservesWillBeNotifiedIfAnObservedPropertyChanges()
    {
        $action = new PropertyChangedAction(['name' => 'new name']);

        $this->testPropertiesObservable->setName('new name');

        $this->assertTrue($this->testObserverSpy->hasMethodBeenCalledWith('handleAction', [$action], false));
    }
}
