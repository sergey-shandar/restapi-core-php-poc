<?php

namespace RestApiCore;


abstract class TypeInfo
{
    /**
     * @param mixed $data
     * @return mixed
     */
    public abstract function deserialize($data);
}
