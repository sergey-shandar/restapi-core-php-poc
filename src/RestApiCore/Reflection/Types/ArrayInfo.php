<?php
namespace RestApiCore\Reflection\Types;

use RestApiCore\Json\FromSeq;

/**
 * Class ArrayType.
 *
 * PHP: [ 'a', 'b', 'c' ]
 * JSON: [ "a", "b", "c" ]
 */
final class ArrayInfo extends Info
{
    /**
     * @var Info
     */
    private $itemType;

    /**
     * ArrayType constructor.
     *
     * @param Info $itemType
     */
    public function __construct(Info $itemType)
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
        $result = new FromSeq();
        foreach ($object as $item) {
            $result->append($itemType->jsonSerialize($item));
        }
        return '[' . $result->get() . ']';
    }
}