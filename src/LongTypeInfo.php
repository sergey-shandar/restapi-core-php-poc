<?php

namespace RestApiCore;

final class LongTypeInfo extends TypeInfo
{
    /**
     * @param string|int $data
     * @return string
     */
    public function deserialize($data)
    {
        return strval($data);
    }

    public static function create()
    {
        return new self();
    }
}