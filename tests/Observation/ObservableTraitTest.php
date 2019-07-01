<?php declare(strict_types = 1);

namespace Observation;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Observation\ObservableTrait
 * @uses \Observation\Action
 * @uses \TestHelpers\SpyTrait
 */
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

        $this->testObserverSpy1->assertMethodHasBeenCalledWith('handleAction', [$action]);
        $this->testObserverSpy2->assertMethodHasBeenCalledWith('handleAction', [$action]);
    }
}
