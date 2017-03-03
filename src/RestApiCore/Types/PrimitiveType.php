<?php
namespace RestApiCore\Types;

abstract class PrimitiveType extends Type
{
    /**
     * @param mixed $data
     * @return mixed
     */
    protected function deserializeNotNull($data)
    {
        return $data;
    }
}
