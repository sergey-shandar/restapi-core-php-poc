<?php
namespace RestApiCore\Reflection\Types;

use RestApiCore\Json\Common;

/**
 * Class DateTimeInfo
 *
 * PHP: new \DateTime("...")
 * JSON: "..."
 */
final class DateTimeInfo extends TypeInfo
{
    /**
     * @return DateTimeInfo
     */
    public static function create()
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new DateTimeInfo();
        }
        return $instance;
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

    private function __construct()
    {
    }
}