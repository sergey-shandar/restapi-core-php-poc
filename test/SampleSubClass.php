<?php
use RestApiCore\Types\ClassType;
use RestApiCore\Types\PrimitiveType;
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
     * @return ClassType
     */
    public static function createClassType()
    {
        return new ClassType(
            self::class,
            [
                new PropertyInfo('a', 'a', PrimitiveType::create()),
            ]);
    }
}