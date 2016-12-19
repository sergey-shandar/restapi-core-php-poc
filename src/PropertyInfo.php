<?php

namespace RestApiCore;


class PropertyInfo
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
     * @var TypeInfo $typeInfo
     */
    public $typeInfo;

    /**
     * PropertyInfo constructor.
     *
     * @param string   $name
     * @param string   $wireName
     * @param TypeInfo $typeInfo
     */
    function __construct($name, $wireName, TypeInfo $typeInfo)
    {
        $this->name = $name;
        $this->wireName = $wireName;
        $this->typeInfo = $typeInfo;
    }
}
