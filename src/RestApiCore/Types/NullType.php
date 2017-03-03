<?php
namespace RestApiCore\Types;

use RestApiCore\Json\Common;

final class NullType extends PrimitiveType
{
    /**
     * @return self
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function jsonSerializeNotNull($object)
    {
        return Common::NULL;
    }
}