<?php
namespace RestApiCore;


class Core
{
    const BOOLEAN_TYPE = 'boolean';
    const INTEGER_TYPE = 'integer';
    const DOUBLE_TYPE = 'double';
    const STRING_TYPE = 'string';

    const OBJECT_TYPE = 'object';
    const ARRAY_TYPE = 'array';

    /**
     * @param mixed $object
     *
     * @return mixed
     */
    public static function serialize($object)
    {
        if ($object === null) {
            return null;
        }

        $typeName = gettype($object);
        switch ($typeName) {
            case self::ARRAY_TYPE:
                $result = [];
                foreach ($object as $dataItem) {
                    $result[] = self::serialize($dataItem);
                }
                return $result;

            case self::OBJECT_TYPE:
                $classInfo = self::getClassInfo(get_class($object));
                $result = [];
                foreach ($classInfo as $propertyInfo) {
                    $name = $propertyInfo->name;
                    $value = self::serialize($object->$name);
                    if ($value != null) {
                        $result[$propertyInfo->wireName] = $value;
                    }
                }
                return $result;

            // case self::BOOLEAN_TYPE:
            // case self::INTEGER_TYPE:
            // case self::DOUBLE_TYPE:
            // case self::STRING_TYPE:
            default:
                return $object;
        }
    }

    /**
     * @param mixed $data deserialized JSON
     * @param TypeInfo $typeInfo
     *
     * @return mixed
     */
    public static function deserialize($data, TypeInfo $typeInfo)
    {
        if ($data === null) {
            return null;
        }

        if ($typeInfo->isArray()) {
            $result = [];
            $itemTypeInfo = $typeInfo->getItemTypeInfo();
            foreach ($data as $dataItem) {
                $result[] = self::deserialize($dataItem, $itemTypeInfo);
            }
            return $result;
        } // $dimensionCount === 0.
        else {
            $typeName = $typeInfo->name;
            switch ($typeName) {
                case self::BOOLEAN_TYPE:
                case self::INTEGER_TYPE:
                case self::DOUBLE_TYPE:
                case self::STRING_TYPE:
                    return $data;

                // $typeName is a class name
                default:
                    $result = new $typeName();
                    $classInfo = self::getClassInfo($typeName);
                    foreach ($classInfo as $propertyInfo) {
                        if (array_key_exists($propertyInfo->wireName, $data)) {
                            $name = $propertyInfo->name;
                            $result->$name = self::deserialize(
                                $data[$propertyInfo->wireName],
                                $propertyInfo->typeInfo);
                        }
                    }
                    return $result;
            }
        }
    }

    /**
     * @param string $className
     *
     * @return PropertyInfo[]
     */
    private static function getClassInfo($className)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $className::getClassInfo();
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private function __constructor() {}
}