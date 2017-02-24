<?php
namespace RestApiCore\Types;

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
     * @param array $object
     * @return \stdClass
     */
    protected function serializeNotNull($object)
    {
        $result = new \stdClass();
        $itemType = $this->itemType;
        foreach ($object as $key => $value) {
            $result->$key = $itemType->serialize($value);
        }
        return $result;
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
            $result[$key] = $itemType->serialize($value);
        }
        return $result;
    }
}