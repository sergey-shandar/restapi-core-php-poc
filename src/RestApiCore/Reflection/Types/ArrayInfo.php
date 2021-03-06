<?php
namespace RestApiCore\Reflection\Types;

use RestApiCore\Json\FromSeq;

/**
 * Class ArrayType.
 *
 * PHP: [ 'a', 'b', 'c' ]
 * JSON: [ "a", "b", "c" ]
 */
final class ArrayInfo extends TypeInfo
{
    /**
     * @var TypeInfo
     */
    private $itemType;

    /**
     * constructor.
     *
     * Use the TypeInfo::createArray() function instead.
     *
     * @param TypeInfo $itemType
     */
    public function __construct(TypeInfo $itemType)
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