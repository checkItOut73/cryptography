<?php declare(strict_types = 1);

namespace Tools\Observation;

use Observation\PropertiesObservableTrait;
use Tools\StringEditor;

class ObservableStringEditor extends StringEditor
{
    use PropertiesObservableTrait;

    /**
     * @return string[]
     */
    protected function getObservedPropertiesChangeActionCreators(): array
    {
        return [
            'string' => function () {
                return new StringChangedAction(['string' => $this->string]);
            },
            'pointedCharacterIndex' => function () {
                return new PointerMovedAction([
                    'pointedCharacterIndex' => $this->pointedCharacterIndex,
                    'pointedCharacter' => $this->getPointedCharacter()
                ]);
            },
            'readString' => function () {
                return new ReadStringChangedAction(['readString' => $this->readString]);
            }
        ];
    }
}
