<?php declare(strict_types = 1);

namespace TestHelpers;

class TestClass
{
    /** @var array $testData */
    private $testData = [];

    /**
     * @param array $testData
     */
    public function __construct(array $testData)
    {
        $this->testData = $testData;
    }
}
