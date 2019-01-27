<?php declare(strict_types = 1);

namespace Observation;

use PHPUnit\Framework\TestCase;

class ObservableTraitTest extends TestCase
{
    /** @var TestObserverSpy $observer1 */
    private $observer1;

    /** @var TestObserverSpy $observer2 */
    private $observer2;

    /** @var TestObservable $observable */
    private $observable;

    public function setUp()
    {
        $this->observer1 = new TestObserverSpy();
        $this->observer2 = new TestObserverSpy();

        $this->observable = new TestObservable();
        $this->observable->addObserver($this->observer1);
        $this->observable->addObserver($this->observer2);
    }

    public function testTheSubscribedObservesWillBeNotified()
    {
        $action = new Action('SOME_ACTION_NAME', ['someActionProperty' => 'someActionValue']);

        $this->observable->notifyObservers($action);

        $this->assertTrue($this->observer1->hasMethodBeenCalledWith('handleAction', [$action]));
        $this->assertTrue($this->observer2->hasMethodBeenCalledWith('handleAction', [$action]));
    }
}
