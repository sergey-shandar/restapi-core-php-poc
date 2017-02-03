<?php

namespace RestApiCore\Type;


abstract class Type
{
    const OBJECT_TYPE = 'object';
    const ARRAY_TYPE = 'array';
    const STRING_TYPE = 'string';

    /**
     * @param mixed $data
     * @return mixed
     */
    public abstract function deserialize($data);

    /**
     * @return ArrayType
     */
    public function createArray()
    {
        return new ArrayType($this);
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
            $result[] = Type::serialize($dataItem);
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
     * @param \DateTime $dateTime
     * @return string
     */
    public static function serializeDateTime(\DateTime $dateTime)
    {
        return $dateTime->format('Y-m-d\TH:i:s.u\Z');
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
                if ($object instanceof \DateTime) {
                    return self::serializeDateTime($object);
                }
                return self::createClassInfo(get_class($object))->serializeClass($object);

            default:
                return self::serializePrimitive($object);
        }
    }

    /**
     * @param string $className
     *
     * @return ClassType
     */
    private static function createClassInfo($className)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $className::createClassInfo();
    }
}
