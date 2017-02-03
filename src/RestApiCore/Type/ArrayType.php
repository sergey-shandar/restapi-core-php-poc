<?php
namespace RestApiCore\Type;


final class ArrayType extends Type
{
    /**
     * @var Type $itemTypeInfo
     */
    public $itemTypeInfo;

    /**
     * ArrayTypeInfo constructor.
     *
     * @param Type $itemTypeInfo
     */
    public function __construct(Type $itemTypeInfo)
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
        foreach ($data as $key => $dataItem) {
            $result[$key] = $this->itemTypeInfo->deserialize($dataItem);
        }
        return $result;
    }
}