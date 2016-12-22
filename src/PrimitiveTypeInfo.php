<?php
namespace RestApiCore;

class PrimitiveTypeInfo extends TypeInfo
{
    /**
     * @param mixed $data
     *
     * @return mixed
     */
    public function deserialize($data)
    {
        return $data;
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public static function serialize($data)
    {
        return $data;
    }

    public static function create()
    {
        return new PrimitiveTypeInfo();
    }

    private function __construct() {}
}
