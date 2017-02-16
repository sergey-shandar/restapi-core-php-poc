<?php
namespace RestApiCore\Type;

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
     * @param \DateInterval $object
     * @return string
     */
    protected function serializeNotNull($object)
    {
        return 'P'
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
    }

    /**
     * @param string $data
     * @return \DateInterval
     */
    protected function deserializeNotNull($data)
    {
        return new \DateInterval($data);
    }
}