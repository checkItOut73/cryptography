<?php declare(strict_types = 1);

namespace Observation;

use PHPUnit\Framework\TestCase;

class ActionTest extends TestCase
{
    public function testAnEmptyArrayIsSetForDataAsDefault()
    {
        $action = new Action();

        $this->assertEquals([], $action->getData());
    }

    public function testTheGivenDataIsSet()
    {
        $action = new Action(['someActionProperty' => 'someActionValue']);

        $this->assertEquals(['someActionProperty' => 'someActionValue'], $action->getData());
    }

    public function testMagicalGetterReturnsDataProperties()
    {
        $action = new Action(['someActionProperty' => 'someActionValue']);

        $this->assertEquals('someActionValue', $action->getSomeActionProperty());
    }

    public function testMagicalGetterReturnsNullForUndefinedProperties()
    {
        $action = new Action(['someActionProperty' => 'someActionValue']);

        $this->assertNull($action->getSomeUndefinedActionProperty());
    }
}
