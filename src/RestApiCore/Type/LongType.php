<?php
namespace RestApiCore\Type;

final class LongType extends Type
{
    /**
     * @return LongType
     */
    public static function create()
    {
        return new LongType();
    }

    /**
     * @param int|string $object
     * @return string
     */
    protected function serializeNotNull($object)
    {
        return strval($object);
    }

    /**
     * @param string|int $data
     * @return string
     */
    protected function deserializeNotNull($data)
    {
        return strval($data);
    }
}