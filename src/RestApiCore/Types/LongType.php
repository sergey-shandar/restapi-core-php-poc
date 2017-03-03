<?php
namespace RestApiCore\Types;

/**
 * Class LongType
 * @package RestApiCore\Types
 *
 * The wire 'long' type is always [de]serialized as a string because only PHP x64 supports 64 bit integers. See
 * http://php.net/manual/en/function.json-decode.php
 *
 * Note: Always use the JSON_BIGINT_AS_STRING option to deserialize from Json or Json::decode() function instead of
 * json_decode().
 */
final class LongType extends Type
{
    /**
     * @return LongType
     */
    public static function create()
    {
        return new LongType();
    }

    /**
     * @param string $object
     * @return string
     */
    protected function deserializeNotNull($object)
    {
        return strval($object);
    }

    /**
     * @param string $object
     * @return string
     */
    public function jsonSerializeNotNull($object)
    {
        return bcadd($object, '0');
    }
}