<?php
namespace RestApiCore\Reflection\Types;

/**
 * Class NumberInfo
 *
 * int|float
 *
 * PHP: 1234.56, 59
 * JSON: 1234.56, 59
 */
final class NumberInfo extends PrimitiveInfo
{
    /**
     * @return NumberInfo
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @param int|float $object
     * @return string
     */
    public function jsonSerializeNotNull($object)
    {
        $type = gettype($object);
        return $type === 'integer' || $type === 'double' ? strval($object) : '0';
    }
}