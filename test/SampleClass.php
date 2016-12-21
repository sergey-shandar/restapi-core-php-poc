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
     * SampleClass constructor.
     *
     * @param int $a
     * @param string[][][] $b
     * @param int[] $c
     */
    public function __construct($a = null, array $b = null, array $c = null)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
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