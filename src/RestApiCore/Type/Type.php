<?php
namespace RestApiCore\Type;

abstract class Type
{
    const ARRAY_TYPE = 'array';

    /**
     * @return ArrayType
     */
    public function createArray()
    {
        return new ArrayType($this);
    }

    public function createMap()
    {
        return new MapType($this);
    }

    /**
     * @param mixed|null $object
     * @return mixed|null
     */
    public function serialize($object)
    {
        return $object === null ? null : $this->serializeNotNull($object);
    }

    /**
     * @param mixed|null $data
     * @return mixed|null
     */
    public function deserialize($data)
    {
        return $data === null ? null : $this->deserializeNotNull($data);
    }

    /**
     * @param mixed $object
     * @return mixed
     */
    protected abstract function serializeNotNull($object);

    /**
     * @param mixed $data
     * @return mixed
     */
    protected abstract function deserializeNotNull($data);
}
