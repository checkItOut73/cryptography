<?php declare(strict_types = 1);

namespace Algorithms\TranspositionCipher;

use Tools\StringEditor;
use Tools\Exceptions\EmptyStringParameterException;
use Tools\Exceptions\StringCharacterIndexOutOfBoundsException;
use Tools\Exceptions\OperationOnEmptyStringException;
use Tools\Exceptions\InvalidCharacterParameterException;
use Tools\Exceptions\StringCharacterNotContainedException;

class ModuloOffsetTransposition
{
    /** @var StringEditor $stringEditor */
    private $stringEditor;

    /**
     * @param StringEditor $stringEditor
     */
    public function __construct(StringEditor $stringEditor)
    {
        $this->stringEditor = $stringEditor;
    }

    /**
     * @param string $message
     * @param string[] $keys
     * @return string
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws OperationOnEmptyStringException
     */
    public function getEncryptedMessage(string $message, array $keys): string
    {
        foreach ($keys as $key) {
            $message = $this->getTransposedString($message, $key);
        }

        return $message;
    }

    /**
     * @param string $string
     * @param string $key
     * @return string
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws OperationOnEmptyStringException
     */
    private function getTransposedString(string $string, string $key): string
    {
        $this->stringEditor->setString($string);

        while (!$this->stringEditor->isStringEmpty()) {
            foreach (str_split($key) as $keyCharacter) {
                $characterPositionInAlphabet = $this->getCharacterPositionInAlphabet($keyCharacter);

                $this->stringEditor->moveForwards($characterPositionInAlphabet);
                $this->stringEditor->cutPointedCharacter();

                if ($this->stringEditor->isStringEmpty()) {
                    break;
                }
            }
        }

        return $this->stringEditor->getFlushedReadString();
    }

    /**
     * @param string $characterOfAlphabet
     * @return int
     */
    private function getCharacterPositionInAlphabet(string $characterOfAlphabet): int
    {
        return ord(strtoupper($characterOfAlphabet)) - ord('A') + 1;
    }

    /**
     * @param string $message
     * @param string[] $keys
     * @return string
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws InvalidCharacterParameterException
     * @throws OperationOnEmptyStringException
     */
    public function getDecryptedMessage(string $message, array $keys): string
    {
        foreach (array_reverse($keys) as $key) {
            $message = $this->getReversinglyTransposedText($message, $key);
        }

        return $message;
    }

    /**
     * @param string $text
     * @param string $key
     * @return string
     * @throws EmptyStringParameterException
     * @throws OperationOnEmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     * @throws InvalidCharacterParameterException
     */
    private function getReversinglyTransposedText(string $text, string $key): string
    {
        $this->stringEditor->setString(str_repeat('#', strlen($text)));

        while ($this->stringEditor->isCharacterContained('#')) {
            foreach (str_split($key) as $keyCharacter) {
                try {
                    $letterPositionInAlphabet = $this->getCharacterPositionInAlphabet($keyCharacter);

                    for ($stepsMoved = 0; $stepsMoved < $letterPositionInAlphabet; $stepsMoved++) {
                        $this->stringEditor->moveToNextCharacter('#');
                    }

                    $this->stringEditor->setPointedCharacter($text[0]);
                    $text = substr($text, 1);
                    $this->stringEditor->moveToNextCharacter('#');
                } catch (StringCharacterNotContainedException $exception) {
                    break;
                }
            }
        }

        return $this->stringEditor->getString();
    }
}
