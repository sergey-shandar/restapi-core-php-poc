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
     * @return self
     */
    public static function create()
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new BooleanInfo();
        }
        return $instance;
    }

    /**
     * @param bool $object
     * @return string
     */
    public function jsonSerializeNotNull($object)
    {
        return $object ? 'true' : 'false';
    }

    private function __construct()
    {
    }
}