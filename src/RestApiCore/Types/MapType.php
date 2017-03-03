<?php
namespace RestApiCore\Types;

use RestApiCore\Json\ObjectBuilder;

final class MapType extends Type
{
    /**
     * @var Type
     */
    private $itemType;

    /**
     * MapType constructor.
     * @param Type $itemType
     */
    public function __construct(Type $itemType)
    {
        $this->itemType = $itemType;
    }

    /**
     * @param \stdClass $data
     * @return array
     */
    protected function deserializeNotNull($data)
    {
        $result = [];
        $itemType = $this->itemType;
        foreach (get_object_vars($data) as $key => $value) {
            $result[$key] = $itemType->deserialize($value);
        }
        return $result;
    }

    /**
     * @param array $object
     * @return string
     */
    public function jsonSerializeNotNull($object)
    {
        $result = new ObjectBuilder();
        $itemType = $this->itemType;
        foreach ($object as $key => $value) {
            $result->append($itemType, $key, $value);
        }
        return $result->get();
    }
}