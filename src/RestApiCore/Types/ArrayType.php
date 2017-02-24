<?php
namespace RestApiCore\Types;

final class ArrayType extends Type
{
    /**
     * @var Type
     */
    private $itemType;

    /**
     * ArrayType constructor.
     * @param Type $itemType
     */
    public function __construct(Type $itemType)
    {
        $this->itemType = $itemType;
    }

    /**
     * @param array $object
     * @return array
     */
    public function serializeNotNull($object)
    {
        $result = [];
        $itemType = $this->itemType;
        foreach ($object as $item) {
            $result[] = $itemType->serialize($item);
        }
        return $result;
    }

    /**
     * @param array $data
     * @return array
     */
    public function deserializeNotNull($data)
    {
        $result = [];
        $itemType = $this->itemType;
        foreach ($data as $item) {
            $result[] = $itemType->deserialize($item);
        }
        return $result;
    }
}