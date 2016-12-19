<?php
namespace RestApiCore;


class TypeInfo
{
    /**
     * @var string $name a type name.
     */
    public $name;

    /**
     * @var int $dimensionCount
     */
    public $dimensionCount;

    /**
     * @param string $name
     * @param int    $dimensionCount
     */
    public function __constructor($name, $dimensionCount = 0)
    {
        $this->name = $name;
        $this->dimensionCount = $dimensionCount;
    }
}
