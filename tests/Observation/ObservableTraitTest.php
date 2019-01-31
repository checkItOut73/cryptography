<?php declare(strict_types = 1);

namespace Observation;

use PHPUnit\Framework\TestCase;

class ObservableTraitTest extends TestCase
{
    /** @var TestObservable $testObservable */
    private $testObservable;

    /** @var TestObserverSpy $testObserverSpy1 */
    private $testObserverSpy1;

    /** @var TestObserverSpy $testObserverSpy2 */
    private $testObserverSpy2;

    public function setUp()
    {
        $this->testObservable = new TestObservable();

        $this->testObserverSpy1 = new TestObserverSpy();
        $this->testObservable->addObserver($this->testObserverSpy1);

        $this->testObserverSpy2 = new TestObserverSpy();
        $this->testObservable->addObserver($this->testObserverSpy2);
    }

    public function testTheSubscribedObservesWillBeNotified()
    {
        $action = new Action(['someActionProperty' => 'someActionValue']);

        $this->testObservable->notifyObservers($action);

        $this->assertTrue($this->testObserverSpy1->hasMethodBeenCalledWith('handleAction', [$action]));
        $this->assertTrue($this->testObserverSpy2->hasMethodBeenCalledWith('handleAction', [$action]));
    }
}
