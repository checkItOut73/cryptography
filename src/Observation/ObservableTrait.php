<?php declare(strict_types = 1);

namespace Observation;

trait ObservableTrait
{
    /** @var Observer[] $observers */
    private $observers = [];

    /**
     * @param Observer $observer
     */
    public function addObserver(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    /**
     * @param Action $action
     */
    private function notifyObservers(Action $action)
    {
        foreach ($this->observers as $observer) {
            $observer->handleAction($action);
        }
    }
}
