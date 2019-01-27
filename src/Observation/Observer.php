<?php declare(strict_types = 1);

namespace Observation;

interface Observer
{
    /**
     * @param Action $action
     */
    public function handleAction(Action $action);
}
