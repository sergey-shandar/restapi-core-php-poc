<?php
namespace RestApiCore;


class TypeInfo
{
    /**
     * @var string $name a type name. It could be 'string', 'boolean', 'integer', 'double' or one of
     *                   serializable classes.
     */
    public $name;

    /**
     * @var int $dimensionCount a number of array dimensions, it's greater than or equal 0.
     */
    public $dimensionCount;

    /**
     * @param string $name a type name. It could be 'string', 'boolean', 'integer', 'double' or one of
     *                     serializable classes.
     * @param int $dimensionCount a number of array dimensions, it's greater than or equal 0.
     */
    public function __construct($name, $dimensionCount = 0)
    {
        $this->name = $name;
        $this->dimensionCount = $dimensionCount;
    }

    /**
     * @return bool
     */
    public function isArray()
    {
        return $this->dimensionCount > 0;
    }

    /**
     * @return TypeInfo
     */
    public function getItemTypeInfo()
    {
        return new TypeInfo($this->name, $this->dimensionCount - 1);
    }
}
