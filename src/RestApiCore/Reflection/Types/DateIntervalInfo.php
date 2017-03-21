<?php
namespace RestApiCore\Reflection\Types;

use RestApiCore\Json\Common;

/**
 * Class DateIntervalInfo
 *
 * PHP: new \DateInterval("...")
 * JSON: "..."
 */
final class DateIntervalInfo extends TypeInfo
{
    /**
     * @return DateIntervalInfo
     */
    public static function create()
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new DateIntervalInfo();
        }
        return $instance;
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

    private function __construct()
    {
    }
}