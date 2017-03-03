<?php
namespace RestApiCore\Types;

final class BooleanType extends PrimitiveType
{
    /**
     * @return self
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @param bool $object
     * @return string
     */
    public function jsonSerializeNotNull($object)
    {
        return $object ? 'true' : 'false';
    }
}