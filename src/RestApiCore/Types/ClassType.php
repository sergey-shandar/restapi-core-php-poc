<?php
namespace RestApiCore\Types;

use RestApiCore\PropertyInfo;

final class ClassType extends Type
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
    public function __construct($name, array $propertyInfoArray)
    {
        $this->name = $name;
        $this->propertyInfoArray = $propertyInfoArray;
    }

    /**
     * @param object $object
     * @return \stdClass
     */
    protected function serializeNotNull($object)
    {
        $result = new \stdClass();
        foreach ($this->propertyInfoArray as $propertyInfo) {
            $name = $propertyInfo->name;
            $value = $propertyInfo->typeInfo->serialize($object->$name);
            if ($value !== null) {
                $wireName = $propertyInfo->wireName;
                $result->$wireName = $value;
            }
        }
        return $result;
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