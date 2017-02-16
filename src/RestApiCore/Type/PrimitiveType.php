<?php
namespace RestApiCore\Type;

final class PrimitiveType extends Type
{
    /**
     * @return PrimitiveType
     */
    public static function create()
    {
        return new PrimitiveType();
    }

    /**
     * @param mixed $object
     * @return mixed
     */
    protected function serializeNotNull($object)
    {
        return $object;
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    protected function deserializeNotNull($data)
    {
        return $data;
    }
}
