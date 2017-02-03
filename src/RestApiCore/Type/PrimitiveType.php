<?php
namespace RestApiCore\Type;

final class PrimitiveType extends Type
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

    public static function create()
    {
        return new PrimitiveType();
    }

    private function __construct() {}
}
