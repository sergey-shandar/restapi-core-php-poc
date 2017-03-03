<?php
namespace RestApiCore\Types;

use RestApiCore\Json\Common;

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
     * @param mixed|null $object
     * @return string
     */
    public function jsonSerialize($object)
    {
        return $object === null ? Common::NULL : $this->jsonSerializeNotNull($object);
    }

    /**
     * @param string $json
     * @return mixed|null
     */
    public function jsonDeserialize($json)
    {
        return $json === null ? null : $this->deserialize(Common::decode($json));
    }

    /**
     * @param mixed $data
     * @return string
     */
    public abstract function jsonSerializeNotNull($data);

    /**
     * @param mixed $data
     * @return mixed
     */
    protected abstract function deserializeNotNull($data);
}
