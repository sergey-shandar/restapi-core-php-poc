<?php
namespace RestApiCore\Type;

final class LongType extends Type
{
    /**
     * @param string $data
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