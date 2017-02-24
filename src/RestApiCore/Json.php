<?php
namespace RestApiCore;

final class Json
{
    /**
     * @param string $json
     * @return mixed
     */
    public static function decode($json)
    {
        return json_decode($json, false, 512, JSON_BIGINT_AS_STRING);
    }

    private function __construct() {}
}