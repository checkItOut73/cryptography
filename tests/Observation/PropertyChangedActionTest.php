<?php declare(strict_types = 1);

namespace Observation;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Observation\PropertyChangedAction
 */
class PropertyChangedActionTest extends TestCase
{
    /** @var PropertyChangedAction $propertyChangedAction */
    private $propertyChangedAction;

    public function setUp()
    {
        $this->propertyChangedAction = new PropertyChangedAction();
    }

    public function testPropertyChangedActionExtendsAction()
    {
        $this->assertTrue(is_subclass_of($this->propertyChangedAction, Action::class));
    }
}
