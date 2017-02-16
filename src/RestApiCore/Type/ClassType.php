<?php
namespace RestApiCore\Type;

use RestApiCore\PropertyInfo;
use stdClass;

final class ClassType extends Type
{
    /**
     * @var string $name
     */
    public $name;

    /**
     * @var PropertyInfo[] $propertyInfoArray
     */
    public $propertyInfoArray;

    /**
     * ClassTypeInfo constructor.
     *
     * @param string $name
     * @param PropertyInfo[] $propertyInfoArray
     */
    public function __construct($name, array $propertyInfoArray)
    {
        $this->name = $name;
        $this->propertyInfoArray = $propertyInfoArray;
    }

    /**
     * @param object|null $data
     *
     * @return object
     */
    public function deserialize($data)
    {
        if ($data === null)
        {
            return $data;
        }

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

    /**
     * @param object $object
     *
     * @return stdClass
     */
    public function serializeClass($object)
    {
        $result = new stdClass();
        foreach ($this->propertyInfoArray as $propertyInfo) {
            $name = $propertyInfo->name;
            $value = Type::serialize($object->$name);
            if ($value !== null) {
                $wireName = $propertyInfo->wireName;
                $result->$wireName = $value;
            }
        }
        return $result;
    }
}