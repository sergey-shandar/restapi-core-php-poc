<?php

namespace RestApiCore;


abstract class TypeInfo2
{
    /**
     * @param mixed $data
     * @return mixed
     */
    public abstract function deserialize($data);
}

class PrimitiveTypeInfo extends TypeInfo2
{
    public function deserialize($data)
    {
        return $data;
    }

    public static $instance;

    private function __construct()
    {
    }

    private static function init()
    {
        self::$instance = new PrimitiveTypeInfo();
    }
}

class ArrayTypeInfo extends TypeInfo2
{
    /**
     * @var TypeInfo2 $itemTypeInfo
     */
    public $itemTypeInfo;

    /**
     * ArrayTypeInfo constructor.
     *
     * @param TypeInfo2 $itemTypeInfo
     */
    public function __construct(TypeInfo2 $itemTypeInfo)
    {
        $this->itemTypeInfo = $itemTypeInfo;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function deserialize($data)
    {
        $result = [];
        foreach ($data as $dataItem) {
            $result[] = $this->itemTypeInfo->deserialize($dataItem);
        }
        return $result;
    }
}

class ClassTypeInfo extends TypeInfo2
{
    /**
     * @var string $name
     */
    public $name;

    /**
     * ClassTypeInfo constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param array $data
     *
     * @return object
     */
    public function deserialize($data)
    {
        $className = $this->name;
        $result = new $className();
        $classInfo = self::getClassInfo($className);
        foreach ($classInfo as $propertyInfo) {
            $wireName = $propertyInfo->wireName;
            if (array_key_exists($wireName, $data)) {
                $name = $propertyInfo->name;
                $result->$name = $propertyInfo->typeInfo->deserialize($data[$wireName]);
            }
        }
        return $result;
    }

    /**
     * @param string $className
     *
     * @return PropertyInfo2[]
     */
    private static function getClassInfo($className)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $className::getClassInfo();
    }
}