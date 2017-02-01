<?php

namespace RestApiCore;

final class IntTypeInfo extends TypeInfo
{
    /**
     * @param string|int $data
     * @return int
     */
    public function deserialize($data)
    {
        return intval($data);
    }

    public static function create()
    {
        return new self();
    }
}