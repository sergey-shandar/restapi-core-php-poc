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
     * @return PropertyInfo[]
     */
    public static function getClassInfo()
    {
        return [
            new PropertyInfo('a', 'a', new TypeInfo(Core::INTEGER_TYPE)),
            new PropertyInfo('b', 'b', new TypeInfo(Core::STRING_TYPE, 3)),
            new PropertyInfo('c', 'CCC', new TypeInfo(Core::INTEGER_TYPE, 1)),
            new PropertyInfo('d', 'd', new TypeInfo(Core::STRING_TYPE)),
            new PropertyInfo('sub', 'sub', new TypeInfo(SampleSubClass::class)),
        ];
    }

    /**
     * @param array $data
     *
     * @return self
     */
    public static function deserialize(array $data)
    {
        /**
         * @var self $result
         */
        $result = Core::classDeserialize($data, self::class);
        return $result;
    }
}