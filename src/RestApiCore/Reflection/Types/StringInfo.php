<?php
namespace RestApiCore\Reflection\Types;

use RestApiCore\Json\Common;

/**
 * Class StringInfo
 *
 * PHP: 'abc'
 * JSON: "abc"
 */
final class StringInfo extends PrimitiveInfo
{
    /**
     * @return self
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @param string $object
     * @return string
     */
    public function jsonSerializeNotNull($object)
    {
        return Common::encodeStr($object);
    }
}