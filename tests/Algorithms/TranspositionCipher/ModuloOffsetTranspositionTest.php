<?php declare(strict_types = 1);

namespace Algorithms\TranspositionCipher;

use PHPUnit\Framework\TestCase;
use Tools\StringEditor;

class ModuloOffsetTranspositionTest extends TestCase
{
    /** @var ModuloOffsetTransposition $moduloOffsetTransposition */
    private $moduloOffsetTransposition;

    public function setUp()
    {
        $this->moduloOffsetTransposition = new ModuloOffsetTransposition(new StringEditor());
    }

    /**
     * @return array
     */
    public function encryptDataProvider(): array
    {
        return [
            ['0123456789', ['A'],      '1357926084'],
            ['0123456789', ['B'],      '2581607493'],
            ['0123456789', ['ABC'],    '1480526397'],
            ['0123456789', ['A', 'B'], '5283610947'],
        ];
    }

    /**
     * @dataProvider encryptDataProvider
     * @param string $message
     * @param array $keys
     * @param string $expectedEncryptedMessage
     * @throws \Tools\Exceptions\EmptyStringParameterException
     * @throws \Tools\Exceptions\OperationOnEmptyStringException
     * @throws \Tools\Exceptions\StringCharacterIndexOutOfBoundsException
     */
    public function testGetEncryptedMessageReturnsTheCorrectlyEncryptedMessage(
        string $message,
        array $keys,
        string $expectedEncryptedMessage
    ) {
        $this->assertEquals(
            $expectedEncryptedMessage,
            $this->moduloOffsetTransposition->getEncryptedMessage($message, $keys)
        );
    }

    /**
     * @return array
     */
    public function decryptDataProvider(): array
    {
        return array_map(function ($testParameters) {
            return array_reverse($testParameters);
        }, $this->encryptDataProvider());
    }

    /**
     * @dataProvider decryptDataProvider
     * @param string $encryptedMessage
     * @param array $keys
     * @param string $expectedDecryptedMessage
     * @throws \Tools\Exceptions\EmptyStringParameterException
     * @throws \Tools\Exceptions\InvalidCharacterParameterException
     * @throws \Tools\Exceptions\OperationOnEmptyStringException
     * @throws \Tools\Exceptions\StringCharacterIndexOutOfBoundsException
     */
    public function testGetDecryptedMessageReturnsTheCorrectlyDecryptedMessage(
        string $encryptedMessage,
        array $keys,
        string $expectedDecryptedMessage
    ) {
        $this->assertEquals(
            $expectedDecryptedMessage,
            $this->moduloOffsetTransposition->getDecryptedMessage($encryptedMessage, $keys)
        );
    }
}
