<?php
namespace RestApiCore;

class ClassTypeInfo extends TypeInfo
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
     * @param array|null $data
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
            if (array_key_exists($wireName, $data)) {
                $name = $propertyInfo->name;
                $result->$name = $propertyInfo->typeInfo->deserialize($data[$wireName]);
            }
        }
        return $result;
    }

    /**
     * @param object $object
     *
     * @return array
     */
    public function serialize($object)
    {
        $result = [];
        foreach ($this->propertyInfoArray as $propertyInfo) {
            $name = $propertyInfo->name;
            $value = Core::serialize($object->$name);
            if ($value !== null) {
                $result[$propertyInfo->wireName] = $value;
            }
        }
        return $result;
    }
}