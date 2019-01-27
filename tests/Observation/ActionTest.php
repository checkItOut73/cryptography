<?php declare(strict_types = 1);

namespace Observation;

use PHPUnit\Framework\TestCase;

class ActionTest extends TestCase
{
    public function testTheGivenNameIsSetAndAnEmptyArrayIsSetForDataAsDefault()
    {
        $action = new Action('SOME_ACTION_NAME');

        $this->assertEquals('SOME_ACTION_NAME', $action->getName());
        $this->assertEquals([], $action->getData());
    }

    public function testTheGivenDataIsSet()
    {
        $action = new Action('SOME_ACTION_NAME', ['someActionProperty' => 'someActionValue']);

        $this->assertEquals(['someActionProperty' => 'someActionValue'], $action->getData());
    }

    public function testMagicalGetterReturnsDataProperties()
    {
        $action = new Action('SOME_ACTION_NAME', ['someActionProperty' => 'someActionValue']);

        $this->assertEquals('someActionValue', $action->getSomeActionProperty());
    }

    public function testMagicalGetterReturnsNullForUndefinedProperties()
    {
        $action = new Action('SOME_ACTION_NAME', ['someActionProperty' => 'someActionValue']);

        $this->assertNull($action->getSomeUndefinedActionProperty());
    }
}
