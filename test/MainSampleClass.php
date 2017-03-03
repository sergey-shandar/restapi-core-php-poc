<?php

use RestApiCore\PropertyInfo;
use RestApiCore\Types\NumberType;
use RestApiCore\Types\PrimitiveType;
use RestApiCore\Types\ClassType;
use RestApiCore\Types\StringType;

class MainSampleClass
{
    /**
     * @var int
     */
    public $a;

    /**
     * @var string[][][]
     */
    public $b;

    /**
     * @var int[]
     */
    public $c;

    /**
     * An optional parameter.
     *
     * @var string|null
     */
    public $d;

    /**
     * @var SampleSubClass
     */
    public $sub;

    /**
     * @var SampleSubClass[]
     */
    public $subArray;

    /**
     * @param int $a
     *
     * @return self
     */
    public function a($a)
    {
        $this->a = $a;
        return $this;
    }

    /**
     * SampleClass constructor.
     *
     * @param int|null $a
     * @param string[][][]|null $b
     * @param int[]|null $c
     * @param string|null $d
     * @param SampleSubClass|null $sub
     * @param SampleSubClass[]|null $subArray
     */
    public function __construct(
        $a = null, array $b = null, array $c = null, $d = null, $sub = null, array $subArray = null)
    {
        $this->a = $a !== null ? $a : 0;
        $this->b = $b !== null ? $b : [];
        $this->c = $c !== null ? $c : [];
        $this->d = $d;
        $this->sub = $sub !== null ? $sub : new SampleSubClass();
        $this->subArray = $subArray !== null ? $subArray : [];
    }

    /**
     * @return ClassType
     */
    public static function createClassType()
    {
        return new ClassType(
            self::class,
            [
                new PropertyInfo('a', 'a', NumberType::create()),
                new PropertyInfo('b', 'b', StringType::create()->createArray()->createArray()->createArray()),
                new PropertyInfo('c', 'CCC', NumberType::create()->createArray()),
                new PropertyInfo('d', 'd', StringType::create()),
                new PropertyInfo('sub', 'sub', SampleSubClass::createClassType()),
                new PropertyInfo('subArray', 'subArray', SampleSubClass::createClassType()->createArray()),
            ]);
    }
}