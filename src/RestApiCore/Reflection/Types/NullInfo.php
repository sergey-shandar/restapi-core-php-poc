<?php
namespace RestApiCore\Reflection\Types;

use RestApiCore\Json\Common;

/**
 * Class NullInfo
 *
 * PHP: null
 * JSON: null
 */
final class NullInfo extends PrimitiveInfo
{
    /**
     * @return NullInfo
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