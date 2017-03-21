<?php
namespace RestApiCore\Reflection;

use RestApiCore\Reflection\Types\Info;

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
     * @var Info $typeInfo
     */
    public $typeInfo;

    /**
     * PropertyInfo constructor.
     *
     * @param string $name
     * @param string $wireName
     * @param Info $typeInfo
     */
    public function __construct($name, $wireName, Info $typeInfo)
    {
        $this->name = $name;
        $this->wireName = $wireName;
        $this->typeInfo = $typeInfo;
    }
}