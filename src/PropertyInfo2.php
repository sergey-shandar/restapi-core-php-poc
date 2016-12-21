<?php
namespace RestApiCore;


class PropertyInfo2
{
    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $wireName
     */
    public $wireName;

    /**
     * @var TypeInfo2 $typeInfo
     */
    public $typeInfo;

    /**
     * PropertyInfo constructor.
     *
     * @param string $name
     * @param string $wireName
     * @param TypeInfo2 $typeInfo
     */
    public function __construct($name, $wireName, TypeInfo2 $typeInfo)
    {
        $this->name = $name;
        $this->wireName = $wireName;
        $this->typeInfo = $typeInfo;
    }
}