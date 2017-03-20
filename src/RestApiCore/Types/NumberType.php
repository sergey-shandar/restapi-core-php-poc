<?php
namespace RestApiCore\Types;

/**
 * Class NumberType
 *
 * int|float
 *
 * PHP: 1234.56, 59
 * JSON: 1234.56, 59
 *
 * @package RestApiCore\Types
 */
final class NumberType extends PrimitiveType
{
    /**
     * @return self
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