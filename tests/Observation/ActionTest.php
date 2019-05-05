<?php declare(strict_types = 1);

namespace Observation;

use Observation\Exceptions\TriggeredErrorException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Observation\Action
 */
class ActionTest extends TestCase
{
    public function setUp()
    {
        set_error_handler(function ($errorNumber, $errorString) {
            throw new TriggeredErrorException($errorString);
        }, E_USER_ERROR);
    }

    public function tearDown()
    {
        restore_error_handler();
    }

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

    /**
     * @expectedException \Observation\Exceptions\TriggeredErrorException
     * @expectedExceptionMessage Call to undefined method Observation\Action::someUndefinedMethod()
     */
    public function testMagicalGetterTriggersDefaultUndefinedMethodErrorForMethodThatDoesNotStartWithGet()
    {
        $action = new Action([]);

        $action->someUndefinedMethod();
    }
}
