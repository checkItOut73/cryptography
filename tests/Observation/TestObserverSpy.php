<?php declare(strict_types = 1);

namespace Observation;

use TestHelpers\SpyTrait;

class TestObserverSpy implements Observer
{
    use SpyTrait;

    /**
     * @param Action $action
     */
    public function handleAction(Action $action)
    {
        $this->recordCall();
    }
}
