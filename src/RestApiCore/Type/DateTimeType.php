<?php
namespace RestApiCore\Type;

final class DateTimeType extends Type
{
    /**
     * @return DateTimeType
     */
    public static function create()
    {
        return new DateTimeType();
    }

    /**
     * @param \DateTime $object
     * @return string
     */
    protected function serializeNotNull($object)
    {
        return $object->format('Y-m-d\TH:i:s.u\Z');
    }

    /**
     * @param string $data
     * @return \DateTime
     */
    protected function deserializeNotNull($data)
    {
        return new \DateTime($data);
    }
}