<?php
namespace RestApiCore\Reflection\Types;

use RestApiCore\Json\Common;

/**
 * Class StringInfo
 *
 * PHP: 'abc'
 * JSON: "abc"
 */
final class StringInfo extends PrimitiveInfo
{
    /**
     * @return self
     */
    public static function create()
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new StringInfo();
        }
        return $instance;
    }

    /**
     * @param string $object
     * @return string
     */
    public function jsonSerializeNotNull($object)
    {
        return Common::encodeStr($object);
    }

    private function __construct()
    {
    }
}