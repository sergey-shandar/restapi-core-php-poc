<?php
namespace RestApiCore;


class Core
{
    const BOOLEAN_TYPE = 'boolean';
    const INTEGER_TYPE = 'integer';
    const DOUBLE_TYPE = 'double';
    const STRING_TYPE = 'string';

    const OBJECT_TYPE = 'object';
    const ARRAY_TYPE = 'array';

    /**
     * @param mixed $data
     *
     * @return null|void
     */
    public static function serialize($data)
    {
        $typeName = gettype($data);
        switch ($typeName)
        {
            case self::BOOLEAN_TYPE:
                return null;

            case self::INTEGER_TYPE:
                return null;

            case self::DOUBLE_TYPE:
                return null;

            case self::STRING_TYPE:
                return null;

            case self::OBJECT_TYPE:
                return null;

            case self::ARRAY_TYPE:
                return null;
        }
    }

    /**
     * @param array  $json JSON
     * @param string $typeName       a return type name. It could be 'string', 'boolean', 'integer', 'double' or one of
     *                               serializable classes
     * @param int    $dimensionCount a number of array dimensions, it's greater than or equal 0.
     *
     * @return mixed
     */
    public static function deserialize($json, $typeName, $dimensionCount)
    {
        if ($dimensionCount > 0)
        {
            $result = [];
            $itemDimensionCount = $dimensionCount - 1;
            foreach ($json as $jsonItem)
            {
                $result[] = self::deserialize($jsonItem, $typeName, $itemDimensionCount);
            }
            return $result;
        }
        // $dimensionCount == 0.
        else
        {
            switch ($typeName)
            {
                case self::BOOLEAN_TYPE:
                    return $json;

                case self::INTEGER_TYPE:
                    return $json;

                case self::DOUBLE_TYPE:
                    return $json;

                case self::STRING_TYPE:
                    return $json;

                // $typeName is a class name
                default:
                    $typeInfo = $typeName::getTypeInfo();
                    return $json;
            }
        }
    }

    private function __constructor()
    {
    }
}