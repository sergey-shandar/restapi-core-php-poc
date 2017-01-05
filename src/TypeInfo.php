<?php

namespace RestApiCore;


abstract class TypeInfo
{
    const OBJECT_TYPE = 'object';
    const ARRAY_TYPE = 'array';

    /**
     * @param mixed $data
     * @return mixed
     */
    public abstract function deserialize($data);

    /**
     * @return ArrayTypeInfo
     */
    public function createArray()
    {
        return new ArrayTypeInfo($this);
    }

    /**
     * @param array $array
     *
     * @return array
     */
    public static function serializeArray(array $array)
    {
        $result = [];
        foreach ($array as $dataItem) {
            $result[] = TypeInfo::serialize($dataItem);
        }
        return $result;
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public static function serializePrimitive($data)
    {
        return $data;
    }

    /**
     * @param array|object|bool|int|float|string|null $object
     *
     * @return array|bool|int|float|string|null
     */
    public static function serialize($object)
    {
        if ($object === null) {
            return null;
        }

        $typeName = gettype($object);
        switch ($typeName) {
            case self::ARRAY_TYPE:
                return self::serializeArray($object);

            case self::OBJECT_TYPE:
                return self::createClassInfo(get_class($object))->serializeClass($object);

            default:
                return self::serializePrimitive($object);
        }
    }

    /**
     * @param string $className
     *
     * @return ClassTypeInfo
     */
    private static function createClassInfo($className)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $className::createClassInfo();
    }
}
