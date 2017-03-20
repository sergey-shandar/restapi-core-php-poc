<?php
namespace RestApiCore\Types;

use RestApiCore\Json\Common;

/**
 * Class DateIntervalType
 *
 * PHP: new \DateIntervalType()
 * JSON: "..."
 *
 * @package RestApiCore\Types
 */
final class DateIntervalType extends Type
{
    /**
     * @return DateIntervalType
     */
    public static function create()
    {
        return new DateIntervalType();
    }

    /**
     * @param string $data
     * @return \DateInterval
     */
    protected function deserializeNotNull($data)
    {
        return new \DateInterval($data);
    }

    /**
     * @param \DateInterval $object
     * @return string
     */
    public function jsonSerializeNotNull($object)
    {
        $result =
            'P'
            . $object->y
            . 'Y'
            . $object->m
            . 'M'
            . $object->d
            . 'DT'
            . $object->h
            . 'H'
            . $object->i
            . 'M'
            . $object->s
            . 'S';
        return Common::encodeStr($result);
    }
}