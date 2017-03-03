<?php
namespace RestApiCore\Types;

use RestApiCore\Json;
use RestApiCore\Json\ObjectBuilder;
use RestApiCore\Json\SeqBuilder;
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
     * @return string
     */
    public function jsonSerializeNotNull($object)
    {
        $result = new ObjectBuilder();
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