<?php
namespace RestApiCore\Types;

use RestApiCore\Json\Common;

/**
 * Class StringType
 *
 * PHP: 'abc'
 * JSON: "abc"
 *
 * @package RestApiCore\Types
 */
final class StringType extends PrimitiveType
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