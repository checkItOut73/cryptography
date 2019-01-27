<?php declare(strict_types = 1);

namespace Observation;

class TestObservable
{
    use ObservableTrait {
        notifyObservers as private privateNotifyObservers;
    }

    /**
     * @param Action $action
     */
    public function notifyObservers(Action $action)
    {
        $this->privateNotifyObservers($action);
    }
}
