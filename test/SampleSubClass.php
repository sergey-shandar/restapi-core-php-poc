<?php
use RestApiCore\Reflection\Types\ClassInfo;
use RestApiCore\Reflection\Types\NumberInfo;
use RestApiCore\Reflection\PropertyInfo;

class SampleSubClass
{
    /**
     * @var int $a
     */
    public $a;

    /**
     * SampleSubClass constructor.
     *
     * @param int|null $a
     */
    public function __construct($a = null)
    {
        $this->a = $a !== null ? $a : 0;
    }

    /**
     * @return ClassInfo
     */
    public static function createClassType()
    {
        return new ClassInfo(
            self::class,
            [
                new PropertyInfo('a', 'a', NumberInfo::create()),
            ]);
    }
}