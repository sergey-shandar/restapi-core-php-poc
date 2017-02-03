<?php
namespace RestApiCore;


use RestApiCore\Type\Type;

final class PropertyInfo
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
     * @var Type $typeInfo
     */
    public $typeInfo;

    /**
     * PropertyInfo constructor.
     *
     * @param string $name
     * @param string $wireName
     * @param Type $typeInfo
     */
    public function __construct($name, $wireName, Type $typeInfo)
    {
        $this->name = $name;
        $this->wireName = $wireName;
        $this->typeInfo = $typeInfo;
    }
}