<?php
namespace RestApiCore\Json;

final class Common
{
    const NULL = 'null';

    /**
     * @param string $json
     * @return mixed
     */
    public static function decode($json)
    {
        return json_decode($json, false, 512, JSON_BIGINT_AS_STRING);
    }

    /**
     * @param string $str
     * @return string
     */
    public static function encodeStr($str)
    {
        return json_encode($str);
    }

    private function __construct() {}
}