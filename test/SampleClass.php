<?php

use RestApiCore\ArrayTypeInfo;
use RestApiCore\ClassTypeInfo;
use RestApiCore\PrimitiveTypeInfo;
use RestApiCore\PropertyInfo;

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
     * @var int[] $c
     */
    public $c;

    /**
     * An optional parameter.
     *
     * @var string|null $d
     */
    public $d;

    /**
     * @var SampleSubClass $sub
     */
    public $sub;

    /**
     * SampleClass constructor.
     *
     * @param int|null $a
     * @param string[][][]|null $b
     * @param int[]|null $c
     * @param string|null $d
     */
    public function __construct(
        $a = null, array $b = null, array $c = null, $d = null, $sub = null)
    {
        $this->a = $a !== null ? $a : 0;
        $this->b = $b !== null ? $b : [];
        $this->c = $c !== null ? $c : [];
        $this->d = $d;
        $this->sub = $sub !== null ? $sub : new SampleSubClass();
    }

    /**
     * @return ClassTypeInfo
     */
    public static function getClassInfo()
    {
        return new ClassTypeInfo(
            self::class,
            [
                new PropertyInfo('a', 'a', new PrimitiveTypeInfo()),
                new PropertyInfo('b', 'b', new ArrayTypeInfo(new ArrayTypeInfo(new ArrayTypeInfo(new PrimitiveTypeInfo())))),
                new PropertyInfo('c', 'CCC', new PrimitiveTypeInfo()),
                new PropertyInfo('d', 'd', new PrimitiveTypeInfo()),
                new PropertyInfo('sub', 'sub', SampleSubClass::getClassInfo()),
            ]);
    }
}