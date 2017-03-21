<?php
namespace RestApiCore\Reflection\Types;

/**
 * Class PrimitiveInfo
 */
abstract class PrimitiveInfo extends TypeInfo
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
