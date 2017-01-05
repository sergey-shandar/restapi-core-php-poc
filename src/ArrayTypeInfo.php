<?php
namespace RestApiCore;


class ArrayTypeInfo extends TypeInfo
{
    /**
     * @var TypeInfo $itemTypeInfo
     */
    public $itemTypeInfo;

    /**
     * ArrayTypeInfo constructor.
     *
     * @param TypeInfo $itemTypeInfo
     */
    public function __construct(TypeInfo $itemTypeInfo)
    {
        $this->itemTypeInfo = $itemTypeInfo;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function deserialize($data)
    {
        if ($data === null)
        {
            return $data;
        }

        $result = [];
        foreach ($data as $dataItem) {
            $result[] = $this->itemTypeInfo->deserialize($dataItem);
        }
        return $result;
    }
}