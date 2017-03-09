<?php
namespace RestApiCore\Types;

use RestApiCore\Json\SeqBuilder;

final class ArrayType extends Type
{
    /**
     * @var Type
     */
    private $itemType;

    /**
     * ArrayType constructor.
     *
     * @param Type $itemType
     */
    public function __construct(Type $itemType)
    {
        $this->itemType = $itemType;
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

    /**
     * @param array $object
     * @return string
     */
    public function jsonSerializeNotNull($object)
    {
        $itemType = $this->itemType;
        $result = new SeqBuilder();
        foreach ($object as $item) {
            $result->append($itemType->jsonSerialize($item));
        }
        return '[' . $result->get() . ']';
    }
}