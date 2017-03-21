<?php

use RestApiCore\Reflection\Types\ClassInfo;
use RestApiCore\Reflection\Types\NumberInfo;
use RestApiCore\Reflection\Types\StringInfo;

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
     * @return ClassInfo
     */
    public static function createClassType()
    {
        return ClassInfo::create(self::class)
            ->withProperty('a', 'a', NumberInfo::create())
            ->withProperty('b', 'b', StringInfo::create()->createArray()->createArray()->createArray())
            ->withProperty('c', 'CCC', NumberInfo::create()->createArray())
            ->withProperty('d', 'd', StringInfo::create())
            ->withProperty('sub', 'sub', SampleSubClass::createClassType())
            ->withProperty('subArray', 'subArray', SampleSubClass::createClassType()->createArray());
    }
}