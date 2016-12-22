<?php
use RestApiCore\ClassTypeInfo;
use RestApiCore\PrimitiveTypeInfo;
use RestApiCore\PropertyInfo;

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
     * @return ClassTypeInfo
     */
    public static function getClassInfo()
    {
        return new ClassTypeInfo(
            self::class,
            [
                new PropertyInfo('a', 'a', PrimitiveTypeInfo::create()),
            ]);
    }
}