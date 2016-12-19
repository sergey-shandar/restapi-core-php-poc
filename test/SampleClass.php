<?php

use RestApiCore\Core;
use RestApiCore\PropertyInfo;
use RestApiCore\TypeInfo;

class SampleClass
{
    /**
     * @var int $a
     */
    public $a;

    /**
     * @var string[][][] $b
     */
    public $b;

    /**
     * @var SampleClass[] $c
     */
    public $c;

    /**
     * @return PropertyInfo[]
     */
    static function getTypeInfo()
    {
        return [
            new PropertyInfo('a', 'a', new TypeInfo(Core::INTEGER_TYPE)),
            new PropertyInfo('b', 'b', new TypeInfo(Core::STRING_TYPE, 3)),
            new PropertyInfo('c', 'CCC', new TypeInfo(SampleClass::class, 1)),
        ];
    }
}