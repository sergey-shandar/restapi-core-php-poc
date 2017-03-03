<?php
namespace RestApiCore\Types;

use RestApiCore\Json\Common;

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
     * @param string $data
     * @return \DateTime
     */
    protected function deserializeNotNull($data)
    {
        return new \DateTime($data);
    }

    /**
     * @param \DateTime $object
     * @return string
     */
    public function jsonSerializeNotNull($object)
    {
        return Common::encodeStr($object->format('Y-m-d\TH:i:s.u\Z'));
    }
}