<?php
use RestApiCore\Core;
use RestApiCore\PropertyInfo;
use RestApiCore\TypeInfo;

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
     * @return PropertyInfo[]
     */
    public static function getClassInfo()
    {
        return [
            new PropertyInfo('a', 'a', new TypeInfo(Core::INTEGER_TYPE)),
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