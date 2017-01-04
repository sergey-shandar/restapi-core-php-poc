<?php
namespace RestApiCore;

class Core
{
    const OBJECT_TYPE = 'object';
    const ARRAY_TYPE = 'array';

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
                return ArrayTypeInfo::serialize($object);

            case self::OBJECT_TYPE:
                return self::createClassInfo(get_class($object))->serialize($object);

            default:
                return PrimitiveTypeInfo::serialize($object);
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

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private function __constructor() {}
}