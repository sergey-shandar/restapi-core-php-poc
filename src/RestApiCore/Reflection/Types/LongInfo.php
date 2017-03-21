<?php
namespace RestApiCore\Reflection\Types;

/**
 * Class LongInfo
 *
 * PHP: '1234'
 * JSON: 1234
 *
 * The wire 'long' type is always [de]serialized as a string because only PHP x64 supports 64 bit integers. See
 * http://php.net/manual/en/function.json-decode.php
 *
 * Note: Always use the JSON_BIGINT_AS_STRING option to deserialize from Json or Json::decode() function instead of
 * json_decode().
 */
final class LongInfo extends Info
{
    /**
     * @return LongInfo
     */
    public static function create()
    {
        return new LongInfo();
    }

    /**
     * @param string $object
     *
     * @return string
     */
    protected function deserializeNotNull($object)
    {
        return strval($object);
    }

    /**
     * @param string $object
     *
     * @return string
     */
    public function jsonSerializeNotNull($object)
    {
        return bcadd($object, '0');
    }
}