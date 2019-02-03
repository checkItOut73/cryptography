<?php declare(strict_types = 1);

namespace Tools\Observation;

use Observation\Action;
use Observation\PropertiesObservableTrait;
use Tools\StringEditor;
use Tools\Exceptions\OperationOnEmptyStringException;

class ObservableStringEditor extends StringEditor
{
    use PropertiesObservableTrait;

    /**
     * @return string[]
     */
    protected function getObservedPropertyNames(): array
    {
        return ['string', 'pointedCharacterIndex', 'readString'];
    }

    /**
     * @param string $propertyName
     * @return Action
     * @throws OperationOnEmptyStringException
     */
    protected function getPropertyChangedAction(string $propertyName): Action
    {
        switch ($propertyName) {
            case 'string':
                return new StringChangedAction(['string' => $this->string]);
            case 'pointedCharacterIndex':
                return new PointedCharacterChangedAction([
                    'pointedCharacterIndex' => $this->pointedCharacterIndex,
                    'pointedCharacter' => $this->getPointedCharacter()
                ]);
            case 'readString':
                return new ReadStringChangedAction(['readString' => $this->readString]);
        }
    }
}
