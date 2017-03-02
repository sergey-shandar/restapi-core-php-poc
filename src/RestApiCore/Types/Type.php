<?php
namespace RestApiCore\Types;

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
     * The function is used to get parameters from JSON-RPC 2.0 Parameter Structure
     * http://www.jsonrpc.org/specification#parameter_structures
     *
     * - 'by-position' is not supported.
     * - 'by-name' is supported.
     *
     * @param object $params
     * @param string $paramName
     * @return mixed|null
     */
    public function deserializeParam($params, $paramName)
    {
        return isset($params->$paramName) ? $this->deserialize($params->$paramName) : null;
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
