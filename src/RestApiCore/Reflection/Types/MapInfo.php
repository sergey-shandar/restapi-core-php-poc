<?php
namespace RestApiCore\Reflection\Types;

use RestApiCore\Json\FromObject;

/**
 * Class MapInfo
 *
 * PHP: [ 'a' => 12 ]
 * JSON: { "a" : 12 }
 */
final class MapInfo extends TypeInfo
{
    /**
     * @var TypeInfo
     */
    private $itemType;

    /**
     * MapType constructor.
     * @param TypeInfo $itemType
     */
    public function __construct(TypeInfo $itemType)
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
        $result = new FromObject();
        $itemType = $this->itemType;
        foreach ($object as $key => $value) {
            $result->append($itemType, $key, $value);
        }
        return $result->get();
    }
}