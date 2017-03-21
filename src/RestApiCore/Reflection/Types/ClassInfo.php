<?php
namespace RestApiCore\Reflection\Types;

use RestApiCore\Json\FromObject;
use RestApiCore\Reflection\PropertyInfo;

/**
 * Class ClassInfo
 *
 * PHP: class A { public $x; }
 * JSON: { "x": ... }
 */
final class ClassInfo extends Info
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var PropertyInfo[]
     */
    private $propertyInfoArray;

    /**
     * ClassType constructor.
     *
     * @param string $name
     * @param PropertyInfo[] $propertyInfoArray
     */
    public function __construct($name, array $propertyInfoArray = [])
    {
        $this->name = $name;
        $this->propertyInfoArray = $propertyInfoArray;
    }

    /**
     * @param string $name
     *
     * @return ClassInfo
     */
    public static function create($name)
    {
        return new self($name);
    }

    /**
     * @param string $name
     * @param string $wireName
     * @param Info $typeInfo
     *
     * @return ClassInfo
     */
    public function withProperty($name, $wireName, Info $typeInfo)
    {
        $this->propertyInfoArray[] = new PropertyInfo($name, $wireName, $typeInfo);
        return $this;
    }

    /**
     * @param object $object
     * @return string
     */
    public function jsonSerializeNotNull($object)
    {
        $result = new FromObject();
        foreach ($this->propertyInfoArray as $propertyInfo) {
            $name = $propertyInfo->name;
            if (isset($object->$name)) {
                $result->append($propertyInfo->typeInfo, $propertyInfo->wireName, $object->$name);
            }
        }
        return $result->get();
    }

    /**
     * @param \stdClass $data
     * @return object
     */
    protected function deserializeNotNull($data)
    {
        $className = $this->name;
        $result = new $className();
        foreach ($this->propertyInfoArray as $propertyInfo) {
            $wireName = $propertyInfo->wireName;
            if (property_exists($data, $wireName)) {
                $name = $propertyInfo->name;
                $result->$name = $propertyInfo->typeInfo->deserialize($data->$wireName);
            }
        }
        return $result;
    }
}