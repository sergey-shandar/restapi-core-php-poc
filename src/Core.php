<?php
namespace RestApiCore;


class Core
{
    /**
     * @param mixed $data
     */
    public static function serialize($data)
    {
        $typeName = gettype($data);
        switch ($typeName)
        {
            case 'boolean':
                return null;
            case 'integer':
                return null;
            case 'double':
                return null;
            case 'string':
                return null;
        }
    }
}