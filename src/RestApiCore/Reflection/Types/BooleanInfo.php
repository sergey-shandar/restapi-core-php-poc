<?php
namespace RestApiCore\Reflection\Types;

/**
 * Class BooleanInfo
 *
 * PHP: true, false
 * JSON: true, false
 */
final class BooleanInfo extends PrimitiveInfo
{
    /**
     * @return BooleanInfo
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